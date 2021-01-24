<?php
/**
 * User edit page controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * User edit page controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class UserEdit extends Controller {
    /**
     * Shows user edit page.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        $user->requireRole('admin');
        
        $id = $binders['id'];
        
        $user_mapper = new \Mitopaths\DataMapper\User();
        $user = $user_mapper->read($id);
        
        $this->view('user-edit', [
            'user' => $user
        ]);
        
        return $this;
    }
}