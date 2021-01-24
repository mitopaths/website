<?php
/**
 * Search results page controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Search results page controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class SearchWeb extends Controller {
    /**
     * Shows search results page page.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        $this->requiredParameters($_REQUEST, ['q']);
        $this->optionalParameters($_REQUEST, [
            'filter_type' => [],
            'filter_category' => [],
            'page' => 0,
            'page_size' => 10
        ]);
        
        $solr_mapper = new \Mitopaths\DataMapper\Solr();
        
        $filters = [];
        $filters[] = 'type:(-molecule)';
        if (!empty($_REQUEST['filter_type'])) {
            $filters[] = 'type:(' . implode(' OR ', $_REQUEST['filter_type']) . ')';
        }
        else {
            $filters[] = 'type:none';
        }
        if (!empty($_REQUEST['filter_category'])) {
            $filters[] = 'category:("' . implode('" OR "', $_REQUEST['filter_category']) . '")';
        }
        
        
        $result = $solr_mapper->read(
            $_REQUEST['q'],
            $filters,
            $_REQUEST['page'],
            $_REQUEST['page_size']
        );
        
        $this->view('search', [
            'result' => $result,
            'filter_type' => $_REQUEST['filter_type'],
            'filter_category' => $_REQUEST['filter_category']
        ]);
        
        return $this;
    }
}