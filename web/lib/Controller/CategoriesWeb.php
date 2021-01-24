<?php
/**
 * Browse categories page controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Browse categories page controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class CategoriesWeb extends Controller {
    /**
     * Shows list of categories.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        $solr_mapper = new \Mitopaths\DataMapper\Solr();
        
        $categories = $solr_mapper->read(
            'type:category',
            [],
            0,
            10000,
            ['type'],
            ['id', 'name']
        );
        
        $this->view('browse-categories', ['categories' => $categories['items']]);
        
        return $this;
    }
}
