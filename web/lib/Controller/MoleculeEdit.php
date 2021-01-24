<?php
/**
 * Molecule edit page controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Molecule edit page controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class MoleculeEdit extends Controller {
    /**
     * Shows molecule edit page.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        $user->requireRole('editor');
        
        $name = $binders['name'];
        
        $molecule_mapper = new \Mitopaths\DataMapper\AbstractMolecule();
        $molecule = $molecule_mapper->read($name);
        
        if ($molecule instanceof \Mitopaths\Model\Molecule) {
            $this->view('molecule-edit', [
                'molecule' => $molecule
            ]);
        }
        elseif ($molecule instanceof \Mitopaths\Model\Protein) {
            $this->view('protein-edit', [
                'protein' => $molecule
            ]);
        }
        elseif ($molecule instanceof \Mitopaths\Model\MutatedProtein) {
            $this->view('mutated-protein-edit', [
                'mutated_protein' => $molecule
            ]);
        }
        
        return $this;
    }
}