<?php
/**
 * User controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * User controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class User extends Controller {
    /** @var \Mitopaths\DataMapper\User $user_mapper User data mapper. */
    private $user_mapper;
    
    
    /**
     * Constructor.
     */
    public function __construct() {
        $this->user_mapper = new \Mitopaths\DataMapper\User();
    }
    
    /**
     * Updates a user.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function put($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $authenticated_user = \Mitopaths\Session::getUser();
        $authenticated_user->requireRole('admin');
        
        $user = $this->user_mapper->read($binders['id']);
        
        $this->optionalParameters($_REQUEST, [
            'email' => $user->getEmail(),
            'password' => null,
            'affiliation' => $user->getAffiliation(),
            'role' => $user->getRole()
        ]);
        $user->setEmail($_REQUEST['email'])
            ->setAffiliation($_REQUEST['affiliation'])
            ->setRole($_REQUEST['role']);
        $this->user_mapper->update($user);
        
        if (!empty($_REQUEST['password'])) {
            $this->user_mapper->setPassword($user, $_REQUEST['password']);
        }
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
    
    /**
     * Deletes a user.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function delete($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $authenticated_user = \Mitopaths\Session::getUser();
        if ($authenticated_user->getRole() !== 'admin' && $authenticated_user->getId() !== $binders['id']) {
            throw new \Exception("You are not the owner of the account, nor an administrator.");
        }
        
        $user = $this->user_mapper->read($binders['id']);
        $this->user_mapper->delete($user);
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
}