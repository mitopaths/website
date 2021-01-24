<?php
/**
 * Pathway edit page controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Pathway edit page controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class PathwayEdit extends Controller {
    /**
     * Shows pathway edit page.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        $user->requireRole('editor');
        
        $name = str_replace(['---0', '---1'], ['/', '+'], $binders['name']);
        
        $pathway_mapper = new \Mitopaths\DataMapper\Pathway();
        $pathway = $pathway_mapper->read($name);
        
        if ($pathway instanceof \Mitopaths\Model\MutatedPathway) {
            $this->view('mutated-pathway-edit', [
                'mutated_pathway' => $pathway
            ]);
        }
        elseif ($pathway instanceof \Mitopaths\Model\Pathway) {
            $this->view('pathway-edit', [
                'pathway' => $pathway
            ]);
        }
        
        return $this;
    }
}
