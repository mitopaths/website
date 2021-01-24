<?php
/**
 * Functionalities controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths
 */
namespace Mitopaths\Controller;

/**
 * Functionalities controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Functions extends Controller {
    /**
     * Creates a new functionality.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function post($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        $user->requireRole('editor');
        
        $this->requiredParameters($_REQUEST, ['name']);
        $this->optionalParameters($_REQUEST, ['description' => ""]);
        
        $mapper = new \Mitopaths\DataMapper\Functionality();
        $function = new \Mitopaths\Model\Functionality(
            $_REQUEST['name'],
            $_REQUEST['description']
        );
        $mapper->create($function);
            
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
    
    /**
     * Returns every functionality.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        $mapper = new \Mitopaths\DataMapper\Functionality();
        $functions = $mapper->readAll();
        
        $data = [];
        foreach ($functions as $function) {
            $data[] = [
                'name' => $function->getName(),
                'description' => $function->getDescription()
            ];
        }
        $this->view('format/json', ['data' => $data]);
        
        return $this;
    }
}