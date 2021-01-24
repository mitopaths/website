<?php
/**
 * Pathologies controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths
 */
namespace Mitopaths\Controller;

/**
 * Pathologies controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Pathologies extends Controller {
    /**
     * Creates a new pathology.
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
        
        $mapper = new \Mitopaths\DataMapper\Pathology();
        $pathology = new \Mitopaths\Model\Pathology(
            $_REQUEST['name'],
            $_REQUEST['description']
        );
        $mapper->create($pathology);
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
    
    /**
     * Returns every pathology.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        $mapper = new \Mitopaths\DataMapper\Pathology();
        $pathologies = $mapper->readAll();
        
        $data = [];
        foreach ($pathologies as $pathology) {
            $data[] = [
                'name' => $pathology->getName(),
                'description' => $pathology->getDescription()
            ];
        }
        $this->view('format/json', ['data' => $data]);
        
        return $this;
    }
}