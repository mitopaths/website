<?php
/**
 * Molecule mapper.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\DataMapper
 */
namespace Mitopaths\DataMapper;

/**
 * Molecule mapper.
 *
 * This class follows the Data Mapper Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\DataMapper
 */
class Molecule {
    use SqlServer;
    
    /**
     * Creates a molecule.
     *
     * @param \Mitopaths\Model\Molecule $molecule Molecule to create
     * @return $this This mapper itself
     */
    public function create(\Mitopaths\Model\Molecule &$molecule): Molecule {
        // Inserts abstract molecule information
        $this->query('INSERT INTO abstract_molecule(name, description) VALUES(:name, :description)', [
            ':name' => $molecule->getName(),
            ':description' => $molecule->getDescription()
        ]);
        
        // Inserts molecule information
        $this->query('INSERT INTO molecule(abstract_molecule_name) VALUES(:abstract_molecule_name)', [
            ':abstract_molecule_name' => $molecule->getName()
        ]);
        
        // Inserts attributes information
        foreach ($molecule->getAttributesAsArray() as $key => $value) {
            $this->query('INSERT INTO molecule_attribute(abstract_molecule_name, name, value) VALUES(:abstract_molecule_name, :name, :value)', [
                ':abstract_molecule_name' => $molecule->getName(),
                ':name' => $key,
                ':value' => $value
            ]);
        }
        
        return $this;
    }
    
    /**
     * Reads a molecule.
     *
     * @param string $name Name of the molecule to read
     * @return \Mitopaths\Model\Molecule Molecule
     */
    public function read(string $name) {
        $result = $this->query('SELECT * FROM molecule JOIN abstract_molecule ON molecule.abstract_molecule_name  = abstract_molecule.name WHERE molecule.abstract_molecule_name = :name', [
            ':name' => $name
        ]);
        
        return $this->rowToModel($result->fetch());
    }
    
    /**
     * Updates a molecule.
     *
     * @param \Mitopaths\Model\Molecule $molecule Molecule to update
     * @return $this This mapper itself
     */
    public function update(\Mitopaths\Model\Molecule $molecule) {
        // Updates abstract molecule information
        $this->query('UPDATE abstract_molecule SET description = :description WHERE name = :name', [
            ':name' => $molecule->getName(),
            ':description' => $molecule->getDescription()
        ]);
        
        // Deletes previously set attributes
        $this->query('DELETE FROM molecule_attribute WHERE abstract_molecule_name = :abstract_molecule_name', [
            ':abstract_molecule_name' => $molecule->getName()
        ]);
        
        // Inserts attributes information
        foreach ($molecule->getAttributesAsArray() as $key => $value) {
            $this->query('INSERT INTO molecule_attribute(abstract_molecule_name, name, value) VALUES(:abstract_molecule_name, :name, :value)', [
                ':abstract_molecule_name' => $molecule->getName(),
                ':name' => $key,
                ':value' => $value
            ]);
        }
        
        return $this;
    }
    
    /**
     * Deletes a molecule.
     *
     * @param \Mitopaths\Model\Molecule $molecule Molecule to delete
     * @return $this This mapper itself
     */
    public function delete(\Mitopaths\Model\Molecule $molecule) {
        $this->query('DELETE FROM abstract_molecule WHERE name = :name', [
            ':name' => $molecule->getName()
        ]);
        
        return $this;
    }
    
    
    /**
     * Converts a raw record into a molecule.
     *
     * @param array $row Record to convert
     * @return \Mitopaths\Model\Molecule Molecule
     */
    protected function rowToModel($row) {
        $molecule = new \Mitopaths\Model\Molecule(
            $row['name'],
            $row['description']
        );
        
        $attributes = $this->query('SELECT * FROM molecule_attribute WHERE abstract_molecule_name = :name', [
            ':name' => $row['name']
        ]);
        foreach ($attributes as $attribute) {
            $molecule->addAttribute($attribute['name'], $attribute['value']);
        }
        
        return $molecule;
    }
}
