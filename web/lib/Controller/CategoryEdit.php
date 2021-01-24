<?php
/**
 * Category edit page controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Category edit page controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class CategoryEdit extends Controller {
    /**
     * Shows category edit page.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        $user->requireRole('editor');
        
        $name = $binders['name'];
        
        $category_mapper = new \Mitopaths\DataMapper\MitochondrialProcess();
        $category = $category_mapper->read($name);
        
        $this->view('category-edit', [
            'category' => $category
        ]);
        
        return $this;
    }
}