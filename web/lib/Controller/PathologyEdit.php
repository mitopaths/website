<?php
/**
 * Pathology edit page controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Pathology edit page controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class PathologyEdit extends Controller {
    /**
     * Shows pathology edit page.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        $user->requireRole('editor');
        
        $name = $binders['name'];
        
        $pathology_mapper = new \Mitopaths\DataMapper\Pathology();
        $pathology = $pathology_mapper->read($name);
        
        $this->view('pathology-edit', [
            'pathology' => $pathology
        ]);
        
        return $this;
    }
}