<?php
/**
 * Category page controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Category page controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class CategoryWeb extends Controller {
    /**
     * Shows pathology page.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        $name = str_replace(['---0', '---1'], ['/', '+'], $binders['name']);
        
        $category_mapper = new \Mitopaths\DataMapper\MitochondrialProcess();
        $solr_mapper = new \Mitopaths\DataMapper\Solr();
        
        $category = $category_mapper->read($name);
        $pathways = $solr_mapper->read(
            '*',
            ['type:(pathway OR mutated_pathway)', 'category:"' . $name . '"']
        );
        
        $this->view('category', [
            'category' => $category,
            'pathways' => $pathways['items']
        ]);
        
        return $this;
    }
}
