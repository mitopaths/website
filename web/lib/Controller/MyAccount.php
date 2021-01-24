<?php
/**
 * Account page controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Account page controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class MyAccount extends Controller {
    /**
     * Shows account page.
     *
     * Redirects to login page if user is not authenticated.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        if (!\Mitopaths\Session::isAuthenticated()) {
            header('location: login');
            exit;
        }
        
        $user = \Mitopaths\Session::getUser();
        $user_mapper = new \Mitopaths\DataMapper\User();
        $users = $user_mapper->readAll();
        $this->view('my-account', [
            'user' => $user,
            'users' => $users
        ]);
        
        return $this;
    }
}
