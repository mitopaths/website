<?php
/**
 * Pathology controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Pathology controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Pathology extends Controller {
    /**
     * Updates a pathology.
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
        
        $pathology_mapper = new \Mitopaths\DataMapper\Pathology();
        
        $pathology = new \Mitopaths\Model\Pathology(
            $_REQUEST['name'],
            $_REQUEST['description']
        );
        $pathology_mapper->update($pathology);
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
    
    /**
     * Deletes a pathology.
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
        $pathology_mapper = new \Mitopaths\DataMapper\Pathology();
        
        $pathology = $pathology_mapper->read($name);
        $pathology_mapper->delete($pathology);
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
}