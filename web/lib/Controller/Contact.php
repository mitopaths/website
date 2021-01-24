<?php
/**
 * Contact us controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2020 MitopatHs
 * @package Mitopaths
 */
namespace Mitopaths\Controller;

/**
 * Contact us controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2020 mitopatHs
 * @package Mitopaths\Controller
 */
class Contact extends Controller {
    /**
     * Send a contact request.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function post($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        $this->requiredParameters($_REQUEST, ['message']);

        $config = parse_ini_file('config.ini', true);

        $editor_email = $config['email']['editor'];
        $user_email = $user->getEmail();
        $subject = "MitopatHs: new contact request";
        $headers = 'From: ' . $user_email . "\r\n"
            . 'To: ' . $editor_email . "\r\n"
            . 'Reply-To: ' . $user_email . "\r\n"
            . 'X-Mailer: PHP/' . phpversion() . "\r\n"
            . 'MIME-Version: 1.0' . "\r\n"
            . 'Content-type: text/html;charset=utf-8';

        $message = <<<MESSAGE
<h2>New contact request on mitopatHs</h2>
<p>
    User <a href="mailto:{$user_email}">{$user_email}</a> (affiliation: <em>{$user->getAffiliation()}</em>) has sent a request:
</p>
<pre>
{$_REQUEST['message']}
</pre>
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

        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
}
