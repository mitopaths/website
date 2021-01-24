<?php
/**
 * Functionality controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Functionality controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Functionality extends Controller {
    /**
     * Updates a functionality.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function put($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        $user->requireRole('editor');
        
        $this->requiredParameters($_REQUEST, ['name']);
        $this->optionalParameters($_REQUEST, [
            'description' => ""
        ]);
        
        $function_mapper = new \Mitopaths\DataMapper\Functionality();
        
        $function = new \Mitopaths\Model\Functionality(
            $_REQUEST['name'],
            $_REQUEST['description']
        );
        $function_mapper->update($function);
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
    
    /**
     * Deletes a functionality.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function delete($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        $user->requireRole('editor');
        
        $this->requiredParameters($_REQUEST, ['name']);
        
        $name = $_REQUEST['name'];
        $function_mapper = new \Mitopaths\DataMapper\Functionality();
        
        $function = $function_mapper->read($name);
        $function_mapper->delete($function);
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
}