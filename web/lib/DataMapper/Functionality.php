<?php
/**
 * Functionality mapper.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\DataMapper
 */
namespace Mitopaths\DataMapper;

/**
 * Functionality mapper.
 *
 * This class follows the Data Mapper Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\DataMapper
 */
class Functionality {
    use SqlServer;
    
    
    /**
     * Creates a functionality.
     *
     * @param \Mitopaths\Model\Functionality $function Functionality to create
     * @return $this This mapper itself
     */
    public function create(\Mitopaths\Model\Functionality $function) {
        $this->query('INSERT INTO function(name, description) VALUES(:name, :description)', [
            ':name' => $function->getName(),
            ':description' => $function->getDescription()
        ]);
        
        return $this;
    }
    
    /**
     * Reads a functionality.
     *
     * @param string $name Name of the functionality to read
     * @return \Mitopaths\Model\Functionality Functionality
     */
    public function read(string $name) {
        $result = $this->query('SELECT * FROM function WHERE name = :name', [
            ':name' => $name
        ]);
        
        return $this->rowToModel($result->fetch());
    }
    
    /**
     * Updates a functionality.
     *
     * @param \Mitopaths\Model\Functionality $function Functionality to update
     * @return $this This mapper
     */
    public function update(\Mitopaths\Model\Functionality $function) {
        $this->query('UPDATE function SET description = :description WHERE name = :name', [
            ':name' => $function->getName(),
            ':description' => $function->getDescription()
        ]);
        
        return $this;
    }
    
    /**
     * Deletes a functionality.
     *
     * @param \Mitopaths\Model\Functionality $function Functionality to delete
     * @return $this This mapper
     */
    public function delete(\Mitopaths\Model\Functionality $function) {
        $this->query('DELETE FROM function WHERE name = :name', [
            ':name' => $function->getName()
        ]);
        
        return $this;
    }
    
    /**
     * Reads every functionality.
     *
     * @return array Array of functionalities
     */
    public function readAll() {
        $result = $this->query('SELECT * FROM function ORDER BY name ASC');
        
        return $this->rowsToModels($result);
    }
    
    
    /**
     * Converts a raw record into a functionality.
     *
     * @param array $row Record to convert
     * @return \Mitopaths\Model\Functionality Functionality
     */
    protected function rowToModel($row) {
        return new \Mitopaths\Model\Functionality(
            $row['name'],
            $row['description']
        );
    }
}