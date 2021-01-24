<?php
/**
 * Mitochondrial process mapper.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\DataMapper
 */
namespace Mitopaths\DataMapper;

/**
 * Mitochondrial process mapper.
 *
 * This class follows the Data Mapper Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\DataMapper
 */
class MitochondrialProcess {
    use SqlServer;
    
    
    /**
     * Creates a mitochondrial process.
     *
     * @param \Mitopaths\Model\MitochondrialProcess $mitochondrial_process Mitochondrial process
     * @return $this This mapper itself
     */
    public function create(\Mitopaths\Model\MitochondrialProcess $mitochondrial_process) {
        $this->query('INSERT INTO mitochondrial_process(name, description) VALUES(:name, :description)', [
            ':name' => $mitochondrial_process->getName(),
            ':description' => $mitochondrial_process->getDescription()
        ]);
        
        return $this;
    }
    
    /**
     * Reads a mitochondrial process.
     *
     * @param string $name Name of the mitochondrial process to read
     * @return \Mitopaths\Model\MitochondrialProcess Mitochondrial process
     */
    public function read(string $name) {
        $result = $this->query('SELECT * FROM mitochondrial_process WHERE name = :name', [
            ':name' => $name
        ]);
        
        return $this->rowToModel($result->fetch());
    }
    
    /**
     * Updates a mitochondrial process.
     *
     * @param \Mitopaths\Model\MitochondrialProcess $mitochondrial_process Mitochondrial process to update
     * @return $this This mapper itself
     */
    public function update(\Mitopaths\Model\MitochondrialProcess $mitochondrial_process) {
        $this->query('UPDATE mitochondrial_process SET description = :description WHERE name = :name', [
            ':name' => $mitochondrial_process->getName(),
            ':description' => $mitochondrial_process->getDescription()
        ]);
        
        return $this;
    }
    
    /**
     * Deletes a mitochondrial process.
     *
     * @param \Mitopaths\Model\MitochondrialProcess $mitochondrial_process Mitochondrial process to delete
     * @return $this This mapper itself
     */
    public function delete(\Mitopaths\Model\MitochondrialProcess $mitochondrial_process) {
        $this->query('DELETE FROM mitochondrial_process WHERE name = :name', [
            ':name' => $mitochondrial_process->getName()
        ]);
        
        return $this;
    }
    
    
    /**
     * Converts a raw record into a mitochondrial process.
     *
     * @param array $row Record to convert
     * @return \Mitopaths\Model\MitochondrialProcess Mitochondrial process
     */
    protected function rowToModel($row) {
        return new \Mitopaths\Model\MitochondrialProcess(
            $row['name'],
            $row['description']
        );
    }
}