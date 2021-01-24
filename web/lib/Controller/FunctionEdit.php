<?php
/**
 * Functionality edit page controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Functionality edit page controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class FunctionEdit extends Controller {
    /**
     * Shows functionality edit page.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        $user->requireRole('editor');
        
        $name = $binders['name'];
        
        $function_mapper = new \Mitopaths\DataMapper\Functionality();
        $function = $function_mapper->read($name);
        
        $this->view('function-edit', [
            'function' => $function
        ]);
        
        return $this;
    }
}