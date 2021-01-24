<?php
/**
 * Protein mapper.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\DataMapper
 */
namespace Mitopaths\DataMapper;

/**
 * Protein mapper.
 *
 * This class follows the Data Mapper Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\DataMapper
 */
class Protein {
    use SqlServer;
    
    /**
     * Creates a protein.
     *
     * @param \Mitopaths\Model\Protein $protein Protein to create
     * @return $this This mapper itself
     */
    public function create(\Mitopaths\Model\Protein &$protein): Protein {
        // Inserts abstract molecule information
        $this->query('INSERT INTO abstract_molecule(name, description) VALUES(:name, :description)', [
            ':name' => $protein->getName(),
            ':description' => $protein->getDescription()
        ]);
        
        // Inserts protein information
        $this->query('INSERT INTO protein(abstract_molecule_name) VALUES(:abstract_molecule_name)', [
            ':abstract_molecule_name' => $protein->getName()
        ]);
        
        // Inserts attributes information
        foreach ($protein->getAttributesAsArray() as $key => $value) {
            $this->query('INSERT INTO molecule_attribute(abstract_molecule_name, name, value) VALUES(:abstract_molecule_name, :name, :value)', [
                ':abstract_molecule_name' => $protein->getName(),
                ':name' => $key,
                ':value' => $value
            ]);
        }
        
        return $this;
    }
    
    /**
     * Reads a protein.
     *
     * @param string $name Name of the protein to read
     * @return \Mitopaths\Model\Protein Protein
     */
    public function read(string $name) {
        $result = $this->query('SELECT * FROM protein JOIN abstract_molecule ON protein.abstract_molecule_name  = abstract_molecule.name WHERE protein.abstract_molecule_name = :name', [
            ':name' => $name
        ]);
        
        return $this->rowToModel($result->fetch());
    }
    
    /**
     * Updates a protein.
     *
     * @param \Mitopaths\Model\Protein $protein Protein to update
     * @return $this This mapper
     */
    public function update(\Mitopaths\Model\Protein $protein) {
        // Updates abstract molecule information
        $this->query('UPDATE abstract_molecule SET description = :description WHERE name = :name', [
            ':name' => $protein->getName(),
            ':description' => $protein->getDescription()
        ]);
        
        // Deletes previously set attributes
        $this->query('DELETE FROM molecule_attribute WHERE abstract_molecule_name = :abstract_molecule_name', [
            ':abstract_molecule_name' => $protein->getName()
        ]);
        
        // Inserts attributes information
        foreach ($protein->getAttributesAsArray() as $key => $value) {
            $this->query('INSERT INTO molecule_attribute(abstract_molecule_name, name, value) VALUES(:abstract_molecule_name, :name, :value)', [
                ':abstract_molecule_name' => $protein->getName(),
                ':name' => $key,
                ':value' => $value
            ]);
        }
        
        return $this;
    }
    
    /**
     * Deletes a protein.
     *
     * @param \Mitopaths\Model\Protein $protein Protein to delete
     * @return $this This mapper
     */
    public function delete(\Mitopaths\Model\Protein $protein) {
        $this->query('DELETE FROM abstract_molecule WHERE name = :name', [
            ':name' => $protein->getName()
        ]);
        
        return $this;
    }
    
    /**
     * Reads every protein.
     *
     * @return array Array of proteins
     */
    public function readAll() {
        $result = $this->query('SELECT * FROM protein JOIN abstract_molecule ON protein.abstract_molecule_name  = abstract_molecule.name');
        
        return $this->rowsToModels($result);
        
    }
    
    
    /**
     * Converts a raw record into a protein.
     *
     * @param array $row Record to convert
     * @return \Mitopaths\Model\Protein Protein
     */
    protected function rowToModel($row) {
        $protein = new \Mitopaths\Model\Protein(
            $row['name'],
            $row['description']
        );
        
        $attributes = $this->query('SELECT * FROM molecule_attribute WHERE abstract_molecule_name = :name', [
            ':name' => $row['name']
        ]);
        foreach ($attributes as $attribute) {
            if ($attribute['name'] == 'geneontology link'
            && preg_match('/amigo.geneontology.org\/amigo\/gene_product\/UniProtKB:(.*)/', $attribute['value'], $matches)
        ) {
                $protein_code = $matches[1];
                $protein->addAttribute('uniprot link',  'https://www.uniprot.org/uniprot/' . $protein_code);
                $protein->addAttribute('nextprot link',  'https://www.nextprot.org/entry/NX_' . $protein_code);
            }
            $protein->addAttribute($attribute['name'], $attribute['value']);
        }
        
        return $protein;
    }
}
