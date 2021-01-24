<?php
/**
 * Pathology mapper.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\DataMapper
 */
namespace Mitopaths\DataMapper;

/**
 * Pathology mapper.
 *
 * This class follows the Data Mapper Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\DataMapper
 */
class Pathology {
    use SqlServer;
    
    
    /**
     * Creates a pathology.
     *
     * @param \Mitopaths\Model\Pathology $pathology Pathology to create
     * @return $this This mapper itself
     */
    public function create(\Mitopaths\Model\Pathology $pathology) {
        $this->query('INSERT INTO pathology(name, description) VALUES(:name, :description)', [
            ':name' => $pathology->getName(),
            ':description' => $pathology->getDescription()
        ]);
        
        return $this;
    }
    
    /**
     * Reads a pathology.
     *
     * @param string $name Name of the pathology to read
     * @return \Mitopaths\Model\Pathology Pathology
     */
    public function read(string $name) {
        $result = $this->query('SELECT * FROM pathology WHERE name = :name', [
            ':name' => $name
        ]);
        
        return $this->rowToModel($result->fetch());
    }
    
    /**
     * Updates a pathology.
     *
     * @param \Mitopaths\Model\Pathology $pathology Pathology to update
     * @return $this This mapper itself
     */
    public function update(\Mitopaths\Model\Pathology $pathology) {
        $this->query('UPDATE pathology SET description = :description WHERE name = :name', [
            ':name' => $pathology->getName(),
            ':description' => $pathology->getDescription()
        ]);
        
        return $this;
    }
    
    /**
     * Deletes a pathology.
     *
     * @param \Mitopaths\Model\Pathology $pathology Pathology to delete
     * @return $this This mapper itself
     */
    public function delete(\Mitopaths\Model\Pathology $pathology) {
        $this->query('DELETE FROM pathology WHERE name = :name', [
            ':name' => $pathology->getName()
        ]);
        
        return $this;
    }
    
    
    /**
     * Reads every pathology.
     *
     * @return array Array of pathologies
     */
    public function readAll() {
        $result = $this->query('SELECT * FROM pathology ORDER BY name ASC');
        
        return $this->rowsToModels($result);
    }
    
    
    /**
     * Converts a raw record into a pathology.
     *
     * @param array $row Record to convert
     * @return \Mitopaths\Model\Pathology Pathology
     */
    protected function rowToModel($row) {
        return new \Mitopaths\Model\Pathology(
            $row['name'],
            $row['description']
        );
    }
}