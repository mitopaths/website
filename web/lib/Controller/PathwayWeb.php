<?php
/**
 * Pathway page controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Pathway page controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class PathwayWeb extends Controller {
    /**
     * Shows pathway page.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        $name = str_replace(['---0', '---1'], ['/', '+'], $binders['name']);
        
        $pathway_mapper = new \Mitopaths\DataMapper\Pathway();
        $pathway = $pathway_mapper->read($name);
        
        if ($pathway instanceof \Mitopaths\Model\MutatedPathway) {
            $this->view('mutated-pathway', ['pathway' => $pathway]);
        }
        elseif ($pathway instanceof \Mitopaths\Model\Pathway) {
            $this->view('pathway', ['pathway' => $pathway]);
        }
        
        return $this;
    }
}
