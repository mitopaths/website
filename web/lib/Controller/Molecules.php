<?php
/**
 * Molecules controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths
 */
namespace Mitopaths\Controller;

/**
 * Molecules controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Molecules extends Controller {
    /**
     * Creates a new molecule.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function post($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        $user->requireRole('editor');
        
        $this->requiredParameters($_REQUEST, ['name', 'type']);
        $this->optionalParameters($_REQUEST, [
            'description' => "",
            'attributes_names' => [],
            'attributes_values' => [],
            'lost_functions' => [],
            'gained_functions' => [],
            'pathologies' => []
        ]);
        if ($_REQUEST['type'] === 'mutated_protein') {
            $this->requiredParameters($_REQUEST, ['original_protein']);
        }
        
        $solr_mapper = new \Mitopaths\DataMapper\Solr();
        
        // Reads attributes
        $attributes = [];
        for ($i = 0; $i < count($_REQUEST['attributes_names']); ++$i) {
            $name = $_REQUEST['attributes_names'][$i];
            $value = $_REQUEST['attributes_values'][$i];
            $attributes[$name] = $value;
        }
        
        // Molecule
        if ($_REQUEST['type'] === 'molecule') {
            $mapper = new \Mitopaths\DataMapper\Molecule();
            $molecule = new \Mitopaths\Model\Molecule(
                $_REQUEST['name'],
                $_REQUEST['description'],
                $attributes
            );
            $mapper->create($molecule);
            $solr_mapper->create($molecule);
            
            $this->view('format/json', ['data' => true]);
        }
        
        // Protein
        elseif ($_REQUEST['type'] === 'protein') {
            $mapper = new \Mitopaths\DataMapper\Protein();
            $protein = new \Mitopaths\Model\Protein(
                $_REQUEST['name'],
                $_REQUEST['description'],
                $attributes
            );
            $mapper->create($protein);
            $solr_mapper->create($protein);
            
            $this->view('format/json', ['data' => true]);
        }
        
        // Mutated protein
        elseif ($_REQUEST['type'] === 'mutated_protein') {
            $protein_mapper = new \Mitopaths\DataMapper\Protein();
            $mapper = new \Mitopaths\DataMapper\MutatedProtein();
            
            $original_protein = $protein_mapper->read($_REQUEST['original_protein']);
            
            $function_mapper = new \Mitopaths\DataMapper\Functionality();
            $lost_functions = [];
            foreach ($_REQUEST['lost_functions'] as $function) {
                $lost_functions[] = $function_mapper->read($function);
            }
            
            $gained_functions = [];
            foreach ($_REQUEST['gained_functions'] as $function) {
                $gained_functions[] = $function_mapper->read($function);
            }
            
            $pathology_mapper = new \Mitopaths\DataMapper\Pathology();
            $pathologies = [];
            foreach ($_REQUEST['pathologies'] as $pathology) {
                $pathologies[] = $pathology_mapper->read($pathology);
            }
            
            $mutated_protein = new \Mitopaths\Model\MutatedProtein(
                $_REQUEST['name'],
                $_REQUEST['description'],
                $original_protein,
                $attributes,
                $lost_functions,
                $gained_functions,
                $pathologies
            );
            $mapper->create($mutated_protein);
            $solr_mapper->create($mutated_protein);
            
            $this->view('format/json', ['data' => true]);
        }
        
        return $this;
    }
}