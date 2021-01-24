<?php
/**
 * Users controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths
 */
namespace Mitopaths\Controller;

/**
 * Users controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Users extends Controller {
    /** @var \Mitopaths\DataMapper\User $user_mapper User data mapper. */
    private $user_mapper;
    
    /**
     * Default constructor.
     */
    public function __construct() {
        $this->user_mapper = new \Mitopaths\DataMapper\User();
    }
    
    
    /**
     * Creates a new user.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function post($binders = []) {
        $this->requiredParameters($_REQUEST, ['email', 'password', 'password']);
        
        $user = new \Mitopaths\Model\User(
            null,
            $_REQUEST['email'],
            $_REQUEST['affiliation'],
            'simple'
        );
        $this->user_mapper->create($user, $_REQUEST['password']);
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
    
    /**
     * Returns every user.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        
        $users = $this->user_mapper->readAll();
        
        return $this;
    }
}