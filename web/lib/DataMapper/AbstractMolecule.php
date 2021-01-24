<?php
/**
 * Generic molecule mapper.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\DataMapper
 */
namespace Mitopaths\DataMapper;

/**
 * Generic molecule mapper.
 *
 * This class follows the Data Mapper Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\DataMapper
 */
class AbstractMolecule {
    use SqlServer;
    
    
    /**
     * Creates a molecule.
     *
     * @param \Mitopaths\Model\AbstractMolecule $molecule Molecule
     * @return $this This mapper itself
     */
    public function create(\Mitopaths\Model\AbstractMolecule $molecule) {
        $this->choseMapper($molecule)->create($molecule);
        
        return $this;
    }
    
    /**
     * Reads a molecule.
     *
     * @param string $name Name of the molecule to read
     * @return \Mitopaths\Model\AbstractMolecule Molecule
     * @throw \Exception If molecule does not exist
     */
    public function read(string $name) {
        $molecule_mapper = new Molecule();
        $protein_mapper = new Protein();
        $mutated_protein_mapper = new MutatedProtein();
        
        $result = $this->query(
            'SELECT type FROM (select "molecule" AS type FROM molecule WHERE abstract_molecule_name = :name) AS a '
            . 'UNION (select "protein" AS type FROM protein WHERE abstract_molecule_name = :name)'
            . 'UNION (select "mutated_protein" AS type FROM mutated_protein WHERE abstract_molecule_name = :name)',
            [':name' => $name]
        );
        
        $type = $result->fetch()['type'];
        if ($type === 'molecule') {
            return $molecule_mapper->read($name);
        }
        elseif ($type === 'protein') {
            return $protein_mapper->read($name);
        }
        elseif ($type === 'mutated_protein') {
            return $mutated_protein_mapper->read($name);
        }
        
        throw new \Exception("Molecule $name does not exist.");
    }
    
    /**
     * Updates a molecule.
     *
     * @param \Mitopaths\Model\AbstractMolecule $molecule Molecule to update
     * @return $this This mapper
     */
    public function update(\Mitopaths\Model\AbstractMolecule $molecule) {
        $this->choseMapper($molecule)->update($molecule);
        
        return $this;
    }
    
    /**
     * Deletes a molecule.
     *
     * @param \Mitopaths\Model\AbstractMolecule $molecule Molecule to delete
     * @return $this This mapper
     */
    public function delete(\Mitopaths\Model\AbstractMolecule $molecule) {
        $this->choseMapper($molecule)->delete($molecule);
        
        return $this;
    }
    
    
    /**
     * Not used.
     *
     * @param mixed $row Ignored
     * @return mixed Ignored
     */
    protected function rowToModel($row) {
        return null;
    }
    
    
    /**
     * Chooses the appropriate data mapper depending on the molecule type.
     *
     * @param \Mitopaths\Model\AbstractMolecule $molecule Molecule
     * @return mixed Appropriate data mapper for given molecule
     * @throw \Exception If molecule type is not recognized
     */
    private function choseMapper(\Mitopaths\Model\AbstractMolecule $molecule) {
        if ($molecule instanceof \Mitopaths\Model\Molecule) {
            return new Molecule();
        }
        elseif ($molecule instanceof \Mitopaths\Model\Protein) {
            return new Protein();
        }
        elseif ($molecule instanceof \Mitopaths\Model\MutatedProtein) {
            return new MutatedProtein();
        }
        
        throw new \Exception("Unknown type of molecule.");
    }
}