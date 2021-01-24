<?php
/**
 * Category controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Category controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Category extends Controller {
    /**
     * Updates a category.
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
        
        $category_mapper = new \Mitopaths\DataMapper\MitochondrialProcess();
        $solr_mapper = new \Mitopaths\DataMapper\Solr();
        
        $category = new \Mitopaths\Model\MitochondrialProcess(
            $_REQUEST['name'],
            $_REQUEST['description']
        );
        $category_mapper->update($category);
        $solr_mapper->update($category);
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
    
    /**
     * Deletes a category.
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
        $category_mapper = new \Mitopaths\DataMapper\MitochondrialProcess();
        $solr_mapper = new \Mitopaths\DataMapper\Solr();
        
        $category = $category_mapper->read($name);
        $category_mapper->delete($category);
        $solr_mapper->delete($category);
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
}