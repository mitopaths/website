<?php
/**
 * Search controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Search controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Search extends Controller {
    /**
     * Performs a research and shows result.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        $this->requiredParameters($_REQUEST, ['q']);
        $this->optionalParameters($_REQUEST, [
            'filters' => [],
            'page' => 0,
            'page_size' => 10,
            'search_fields' => [],
            'fields' => []
        ]);
        
        // Runs query
        $solr_mapper = new \Mitopaths\DataMapper\Solr();
        $result = $solr_mapper->read(
            $_REQUEST['q'],
            $_REQUEST['filters'],
            $_REQUEST['page'],
            $_REQUEST['page_size'],
            $_REQUEST['search_fields'],
            $_REQUEST['fields']
        );
        
        $this->view('format/json', ['data' => $result]);
        
        return $this;
    }
}