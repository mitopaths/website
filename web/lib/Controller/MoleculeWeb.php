<?php
/**
 * Molecule page controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Molecule page controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class MoleculeWeb extends Controller {
    /**
     * Shows molecule page.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        $name = $binders['name'];
        
        $molecule_mapper = new \Mitopaths\DataMapper\AbstractMolecule();
        $solr_mapper = new \Mitopaths\DataMapper\Solr();
        $molecule = $molecule_mapper->read($name);
        $pathways = $solr_mapper->read(
            $name,
            ['type:(pathway OR mutated_pathway)'],
            0,
            1000
        );

        if ($molecule instanceof \Mitopaths\Model\Molecule) {
            $this->view('molecule', [
                'molecule' => $molecule
            ]);
        }
        elseif ($molecule instanceof \Mitopaths\Model\Protein) {
            $mutations = $solr_mapper->read(
                '*',
                ['type:mutated_protein', 'original_protein:' . $name],
                0,
                1000
            );

            $this->view('protein', [
                'protein' => $molecule,
                'pathways' => $pathways['items'],
                'mutations' => $mutations['items']
            ]);
        }
        elseif ($molecule instanceof \Mitopaths\Model\MutatedProtein) {
            $this->view('mutated-protein', [
                'mutated_protein' => $molecule,
                'pathways' => $pathways['items']
            ]);
        }
        
        return $this;
    }
}