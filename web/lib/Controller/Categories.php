<?php
/**
 * Categories controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths
 */
namespace Mitopaths\Controller;

/**
 * Categories controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Categories extends Controller {
    /**
     * Creates a new category.
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
        
        $mapper = new \Mitopaths\DataMapper\MitochondrialProcess();
        $solr_mapper = new \Mitopaths\DataMapper\Solr();
        
        $mitochondrial_process = new \Mitopaths\Model\MitochondrialProcess(
            $_REQUEST['name'],
            $_REQUEST['description']
        );
        
        $mapper->create($mitochondrial_process);
        $solr_mapper->create($mitochondrial_process);
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
}