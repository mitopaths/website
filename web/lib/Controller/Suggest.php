<?php
/**
 * Suggest controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Suggest controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Suggest extends Controller {
    /**
     * Sends a suggestion via email, then shows a "thank you" page.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function post($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        
        $config = parse_ini_file('config.ini', true);
        
        $this->requiredParameters($_REQUEST, ['pathway']);
        $path = null;
        if (isset($_FILES['pathway-file'])
            && $_FILES['pathway-file']['error'] === \UPLOAD_ERR_OK
            && $_FILES['pathway-file']['type'] === 'application/pdf'
        ) {
            $name = md5($_FILES['pathway-file']['name'] . rand());
            $path = $config['upload']['dir'] . '/' . $name . '.pdf';
            move_uploaded_file($_FILES['pathway-file']['tmp_name'], $path);
        }
        
        $editor_email = $config['email']['editor'];
        $user_email = $user->getEmail();
        $subject = "MitopatHs: new suggestion";
        $headers = 'From: ' . $user_email . "\r\n"
            . 'To: ' . $editor_email . "\r\n"
            . 'Reply-To: ' . $user_email . "\r\n"
            . 'X-Mailer: PHP/' . phpversion() . "\r\n"
            . 'MIME-Version: 1.0' . "\r\n"
            . 'Content-type: text/html;charset=utf-8';
        
        $message = <<<MESSAGE
<h2>New suggestion on mitopatHs</h2>
<p>
    User <a href="mailto:{$user_email}">{$user_email}</a> (affiliation: <em>{$user->getAffiliation()}</em>) has sent a new suggestion to review:
</p>
<pre>
{$_REQUEST['pathway']}
</pre>
MESSAGE;
        if (!is_null($path)) {
            $message .= '<p>A PDF has been uploaded and is available at web.math.unipd.it/mitopaths/' . $path . '. Copy-paste that address into your browser to download it.</p>';
        }

        $message .= <<<MESSAGE
<hr>
<p>
    You can reply directly to this email to contact <a href="mailto:{$user_email}">{$user_email}</a>.
</p>
MitopatHs
MESSAGE;

        $data = json_encode([
            'personalizations' => [
                [
                    'to' => [
                        ['email' => $editor_email]
                    ]
                ]
            ],
            'from' => [
                'email' => $user_email
            ],
            'subject' => $subject,
            'content' => [
                [
                    'type' => 'text/html',
                    'value' => $message
                ]
            ]
        ]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $config['sendgrid']['api_key'],
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new \Exception("Error while sending data to SendGrid server: " . curl_error($ch));
        }
        curl_close($ch);
        
        $this->view('suggest-done', ['user' => $user]);
        
        return $this;
    }
}
