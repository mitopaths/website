<?php
/**
 * Session controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Session controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Session extends Controller {
    /** @var \Mitopaths\DataMapper\User $user_mapper User data mapper. */
    private $user_mapper;
    
    
    /**
     * Default constructor.
     */
    public function __construct() {
        $this->user_mapper = new \Mitopaths\DataMapper\User();
    }
    
    
    /**
     * Creates a new session.
     * 
     * @param array Associative array of additional parameters
     * @return $this This controller itself
     * @api
     */
    public function post($binders = []) {
        $this->requiredParameters($_REQUEST, ['email', 'password']);
        
        $user = $this->user_mapper->authenticate($_REQUEST['email'], $_REQUEST['password']);
        \Mitopaths\Session::create($user);
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
    
    
    /**
     * Returns data about currently authenticated user.
     * 
     * @param array Associative array of additional parameters
     * @return $this This controller itself
     * @api
     */
    public function get($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        
        $user = \Mitopaths\Session::getUser();
        
        return $this;
    }
    
    
    /**
     * Updates data about currently authenticated user.
     * 
     * @param array Associative array of additional parameters
     * @return $this This controller itself
     * @api
     */
    public function put($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        
        $user = \Mitopaths\Session::getUser();
        $this->optionalParameters($_REQUEST, [
            'email' => $user->getEmail(),
            'password' => null,
            'affiliation' => $user->getAffiliation()
        ]);
        
        $user->setEmail($_REQUEST['email'])->setAffiliation($_REQUEST['affiliation']);
        $this->user_mapper->update($user);
        
        if (!empty($_REQUEST['password'])) {
            $this->user_mapper->setPassword($user, $_REQUEST['password']);
        }
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
    
    
    /**
     * Destroies session.
     * 
     * @param array Associative array of additional parameters
     * @return $this This controller itself
     * @api
     */
    public function delete($binders = []) {
        \Mitopaths\Session::logout();
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
}
