<?php
/**
 * Mutated protein mapper.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\DataMapper
 */
namespace Mitopaths\DataMapper;

/**
 * Mutated protein mapper.
 *
 * This class follows the Data Mapper Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\DataMapper
 */
class MutatedProtein {
    use SqlServer;
    
    
    /**
     * Creates a mutated protein.
     *
     * @param \Mitopaths\Model\MutatedProtein $mutated_protein Mutated protein to create
     * @return $this This mapper itself
     */
    public function create(\Mitopaths\Model\MutatedProtein &$mutated_protein): MutatedProtein {
        // Inserts abstract molecule information
        $this->query('INSERT INTO abstract_molecule(name, description) VALUES(:name, :description)', [
            ':name' => $mutated_protein->getName(),
            ':description' => $mutated_protein->getDescription()
        ]);
        
        // Inserts mutated protein information
        $this->query('INSERT INTO mutated_protein(abstract_molecule_name, original_protein_name) VALUES(:abstract_molecule_name, :original_protein_name)', [
            ':abstract_molecule_name' => $mutated_protein->getName(),
            ':original_protein_name' => $mutated_protein->getOriginalProtein()->getName()
        ]);
        
        // Inserts attributes information
        foreach ($mutated_protein->getAttributesAsArray() as $key => $value) {
            $this->query('INSERT INTO molecule_attribute(abstract_molecule_name, name, value) VALUES(:abstract_molecule_name, :name, :value)', [
                ':abstract_molecule_name' => $mutated_protein->getName(),
                ':name' => $key,
                ':value' => $value
            ]);
        }
        
        // Inserts lost functions information
        foreach ($mutated_protein->getLostFunctionsAsArray() as $function) {
            $this->query('INSERT INTO function_alteration(mutated_protein_name, function_name, type) VALUES(:mutated_protein_name, :function_name, "-")', [
                ':mutated_protein_name' => $mutated_protein->getName(),
                ':function_name' => $function->getName()
            ]);
        }
        
        // Inserts gained functions information
        foreach ($mutated_protein->getGainedFunctionsAsArray() as $function) {
            $this->query('INSERT INTO function_alteration(mutated_protein_name, function_name, type) VALUES(:mutated_protein_name, :function_name, "+")', [
                ':mutated_protein_name' => $mutated_protein->getName(),
                ':function_name' => $function->getName()
            ]);
        }
        
        // Inserts pathology information
        foreach ($mutated_protein->getPathologiesAsArray() as $pathology) {
            $this->query('INSERT INTO mutated_protein_pathology(mutated_protein_name, pathology_name) VALUES(:mutated_protein_name, :pathology_name)', [
                ':mutated_protein_name' => $mutated_protein->getName(),
                ':pathology_name' => $pathology->getName()
            ]);
        }
        
        return $this;
    }
    
    /**
     * Reads a mutated protein.
     *
     * @param string $name Name of the mutated protein to read
     * @return \Mitopaths\Model\MutatedProtein Mutated protein
     */
    public function read(string $name) {
        $result = $this->query('SELECT * FROM mutated_protein JOIN abstract_molecule ON mutated_protein.abstract_molecule_name  = abstract_molecule.name WHERE mutated_protein.abstract_molecule_name = :name', [
            ':name' => $name
        ]);
        
        return $this->rowToModel($result->fetch());
    }
    
    /**
     * Updates a mutated protein.
     *
     * @param \Mitopaths\Model\MutatedProtein $mutated_protein Mutated protein to update
     * @return $this This mapper itself
     */
    public function update(\Mitopaths\Model\MutatedProtein $mutated_protein) {
        // Updates abstract molecule information
        $this->query('UPDATE abstract_molecule SET description = :description WHERE name = :name', [
            ':name' => $mutated_protein->getName(),
            ':description' => $mutated_protein->getDescription()
        ]);
        
        // Updates mutated protein information
        $this->query('UPDATE mutated_protein SET original_protein_name = :original_protein_name WHERE abstract_molecule_name = :abstract_molecule_name', [
            ':abstract_molecule_name' => $mutated_protein->getName(),
            ':original_protein_name' => $mutated_protein->getOriginalProtein()->getName()
        ]);
        
        // Deletes previously set attributes
        $this->query('DELETE FROM molecule_attribute WHERE abstract_molecule_name = :abstract_molecule_name', [
            ':abstract_molecule_name' => $mutated_protein->getName()
        ]);
        
        // Inserts attributes information
        foreach ($mutated_protein->getAttributesAsArray() as $key => $value) {
            $this->query('INSERT INTO molecule_attribute(abstract_molecule_name, name, value) VALUES(:abstract_molecule_name, :name, :value)', [
                ':abstract_molecule_name' => $mutated_protein->getName(),
                ':name' => $key,
                ':value' => $value
            ]);
        }
        
        // Deletes previously set function alteration
        $this->query('DELETE FROM function_alteration WHERE mutated_protein_name = :mutated_protein_name', [
            ':mutated_protein_name' => $mutated_protein->getName()
        ]);
        
        // Inserts lost functions information
        foreach ($mutated_protein->getLostFunctionsAsArray() as $function) {
            $this->query('INSERT INTO function_alteration(mutated_protein_name, function_name, type) VALUES(:mutated_protein_name, :function_name, "-")', [
                ':mutated_protein_name' => $mutated_protein->getName(),
                ':function_name' => $function->getName()
            ]);
        }
        
        // Inserts gained functions information
        foreach ($mutated_protein->getGainedFunctionsAsArray() as $function) {
            $this->query('INSERT INTO function_alteration(mutated_protein_name, function_name, type) VALUES(:mutated_protein_name, :function_name, "+")', [
                ':mutated_protein_name' => $mutated_protein->getName(),
                ':function_name' => $function->getName()
            ]);
        }
        
        // Deletes previously set pathologies
        $this->query('DELETE FROM mutated_protein_pathology WHERE mutated_protein_name = :mutated_protein_name', [
            ':mutated_protein_name' => $mutated_protein->getName()
        ]);
        
        // Inserts pathology information
        foreach ($mutated_protein->getPathologiesAsArray() as $pathology) {
            $this->query('INSERT INTO mutated_protein_pathology(mutated_protein_name, pathology_name) VALUES(:mutated_protein_name, :pathology_name)', [
                ':mutated_protein_name' => $mutated_protein->getName(),
                ':pathology_name' => $pathology->getName()
            ]);
        }
        
        return $this;
    }
    
    /**
     * Deletes a mutated protein.
     *
     * @param \Mitopaths\Model\MutatedProtein $mutated_protein Mutated protein to delete
     * @return $this This mapper itself
     */
    public function delete(\Mitopaths\Model\MutatedProtein $mutated_protein) {
        $this->query('DELETE FROM abstract_molecule WHERE name = :name', [
            ':name' => $mutated_protein->getName()
        ]);
        
        return $this;
    }
    
    
    /**
     * Converts a raw record into a mutated protein.
     *
     * @param array $row Record to convert
     * @return \Mitopaths\Model\MutatedProtein Mutated protein
     */
    protected function rowToModel($row) {
        $protein_mapper = new Protein();
        $original_protein = $protein_mapper->read($row['original_protein_name']);
        
        // Reads attributes
        $attributes = [];
        $result = $this->query('SELECT * FROM molecule_attribute WHERE abstract_molecule_name = :name', [
            ':name' => $row['name']
        ]);
        foreach ($result as $record) {
            $attributes[$record['name']] = $record['value'];
        }
        
        // Reads lost and gained functionalities
        $lost_functions = [];
        $gained_functions = [];
        $result = $this->query('SELECT * FROM function JOIN function_alteration ON function.name = function_alteration.function_name WHERE function_alteration.mutated_protein_name = :name', [
            ':name' => $row['name']
        ]);
        foreach ($result as $record) {
            $function = new \Mitopaths\Model\Functionality(
                $record['name'],
                $record['description']
            );
            if ($record['type'] === '-') {
                $lost_functions[] = $function;
            }
            else {
                $gained_functions[] = $function;
            }
        }
        
        // Reads pathologies
        $pathologies = [];
        $result = $this->query('SELECT * FROM pathology JOIN mutated_protein_pathology ON pathology.name = mutated_protein_pathology.pathology_name WHERE mutated_protein_pathology.mutated_protein_name = :name', [
            ':name' => $row['name']
        ]);
        foreach ($result as $record) {
            $pathologies[] = new \Mitopaths\Model\Pathology(
                $record['name'],
                $record['description']
            );
        }
        
        // Creates mutated protein
        $mutated_protein = new \Mitopaths\Model\MutatedProtein(
            $row['name'],
            $row['description'],
            $original_protein,
            $attributes,
            $lost_functions,
            $gained_functions,
            $pathologies
        );
        
        return $mutated_protein;
    }
}