<?php
/**
 * Browse page controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Browse page controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Browse extends Controller {
    /**
     * Shows list of pathways.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        $solr_mapper = new \Mitopaths\DataMapper\Solr();
        
        $pathways = $solr_mapper->read(
            'type:pathway OR type:mutated_pathway',
            [],
            0,
            10000,
            ['type'],
            ['id', 'name']
        );
        
        $this->view('browse', ['pathways' => $pathways['items']]);
        
        return $this;
    }
}