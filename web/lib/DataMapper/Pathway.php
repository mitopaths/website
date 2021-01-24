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
 * Pathway mapper.
 *
 * This class follows the Data Mapper Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\DataMapper
 */
class Pathway {
    use SqlServer;
    
    
    /**
     * Creates a pathway.
     *
     * @param \Mitopaths\Model\Pathway $pathway Pathway to create
     * @return $this This mapper itself
     */
    public function create(\Mitopaths\Model\Pathway $pathway) {
        $original_pathway_name = null;
        if ($pathway instanceof \Mitopaths\Model\MutatedPathway) {
            $original_pathway_name = $pathway->getOriginalPathway()->getName();
        }
        
        // Inserts pathway information
        $this->query('INSERT INTO pathway(name, original_pathway_name, contributor) VALUES(:name, :original_pathway_name, :contributor)', [
            ':name' => $pathway->getName(),
            ':original_pathway_name' => $original_pathway_name,
            ':contributor' => $pathway->getContributor()
        ]);
        
        // Inserts mitochondrial process information
        foreach ($pathway->getMitochondrialProcessesAsArray() as $mitochondrial_process) {
            $this->insertMitochondrialProcess($pathway, $mitochondrial_process);
        }
        
        // Inserts main theorem
        $theorem = $pathway->getTheorem();
        $this->insertTheorem($pathway, 0, $theorem);
        
        // Inserts steps
        $steps = $pathway->getStepsAsArray();
        for ($i = 0; $i < count($steps); ++$i) {
            $this->insertTheorem($pathway, $i + 1, $steps[$i]);
        }

        // Inserts attributes
        foreach ($pathway->getAttributesAsArray() as $key => $value) {
            $this->insertAttribute($pathway, $key, $value);
        }
        
        return $this;
    }
    
    /**
     * Reads a pathway.
     *
     * @param string $name Name of the pathway to read
     * @return \Mitopaths\Model\Pathway Pathway
     */
    public function read(string $name) {
        $result = $this->query('SELECT * FROM pathway WHERE name = :name', [
            ':name' => $name
        ]);
        
        return $this->rowToModel($result->fetch());
    }
    
    /**
     * Updates a pathway.
     *
     * @param \Mitopaths\Model\Pathway $pathway Pathway to update
     * @return $this This mapper
     */
    public function update(\Mitopaths\Model\Pathway $pathway) {
        $original_pathway_name = null;
        if ($pathway instanceof \Mitopaths\Model\MutatedPathway) {
            $original_pathway_name = $pathway->getOriginalPathway()->getName();
        }
        
        // Updates pathway information
        $this->query('UPDATE pathway SET original_pathway_name = :original_pathway_name, contributor = :contributor WHERE name = :name', [
            ':name' => $pathway->getName(),
            ':original_pathway_name' => $original_pathway_name,
            ':contributor' => $pathway->getContributor()
        ]);
        
        // Deletes information about theorems
        $this->query('DELETE FROM theorem WHERE pathway_name = :pathway_name', [
            ':pathway_name' => $pathway->getName()
        ]);
        
        // Inserts main theorem
        $theorem = $pathway->getTheorem();
        $this->insertTheorem($pathway, 0, $theorem);
        
        // Inserts steps
        $steps = $pathway->getStepsAsArray();
        for ($i = 0; $i < count($steps); ++$i) {
            $this->insertTheorem($pathway, $i + 1, $steps[$i]);
        }
        
        // Deletes information about mitochondrial processes
        $this->query('DELETE FROM pathway_mitochondrial_process WHERE pathway_name = :pathway_name', [
            ':pathway_name' => $pathway->getName()
        ]);
        
        // Inserts mitochondrial process information
        foreach ($pathway->getMitochondrialProcessesAsArray() as $mitochondrial_process) {
            $this->insertMitochondrialProcess($pathway, $mitochondrial_process);
        }

        // Deletes information about attributes
        $this->query('DELETE FROM pathway_attribute WHERE pathway_name = :pathway_name AND name NOT LIKE "image%"', [
            ':pathway_name' => $pathway->getName()
        ]);

        // Inserts attributes information
        foreach ($pathway->getAttributesAsArray() as $key => $value) {
            $this->insertAttribute($pathway, $key, $value);
        }
        
        return $this;
    }
    
    /**
     * Deletes a pathway.
     *
     * @param \Mitopaths\Model\Pathway $pathway Pathway to delete
     * @return $this This mapper
     */
    public function delete(\Mitopaths\Model\Pathway $pathway) {
        $this->query('DELETE FROM pathway WHERE name = :name', [
            ':name' => $pathway->getName()
        ]);
        
        return $this;
    }
    
    
    /**
     * Converts a raw record into a pathway.
     *
     * @param array $row Record to convert
     * @return \Mitopaths\Model\Pathway Pathway
     */
    protected function rowToModel($row) {
        $pathway_name = $row['name'];
        $pathway_contributor = !empty($row['contributor']) ? $row['contributor'] : "";
        $molecule_mapper = new AbstractMolecule();
        $parser = new \Mitopaths\Model\Expression\Parser\Parser($molecule_mapper);
        
        // Reads theorem information
        $result = $this->query('SELECT * FROM theorem WHERE pathway_name = :pathway_name ORDER BY step ASC', [
            ':pathway_name' => $pathway_name
        ]);
        
        // Main theorem
        $record = $result->fetch();
        $theorem = new \Mitopaths\Model\Theorem(
            $parser->parse($record['head']),
            $parser->parse($record['body'])
        );
        
        // Steps
        $steps = [];
        foreach ($result as $record) {
            $steps[] = new \Mitopaths\Model\Theorem(
                $parser->parse($record['head']),
                $parser->parse($record['body'])
            );
        }
        
        // Reads mitochondrial processes information
        $mitochondrial_processes = [];
        $result = $this->query('SELECT * FROM mitochondrial_process JOIN pathway_mitochondrial_process ON mitochondrial_process.name = pathway_mitochondrial_process.mitochondrial_process_name WHERE pathway_mitochondrial_process.pathway_name = :pathway_name', [
            ':pathway_name' => $pathway_name
        ]);
        foreach ($result as $record) {
            $mitochondrial_processes[] = new \Mitopaths\Model\MitochondrialProcess(
                $record['name'],
                $record['description']
            );
        }
        
        // Chooses between pathway and mutated pathway
        if (empty($row['original_pathway_name'])) {
            $pathway = new \Mitopaths\Model\Pathway(
                $pathway_name,
                $pathway_contributor,
                $theorem,
                $steps,
                $mitochondrial_processes
            );
        }
        else {
            $pathway = new \Mitopaths\Model\MutatedPathway(
                $pathway_name,
                $pathway_contributor,
                $theorem,
                $steps,
                $mitochondrial_processes,
                $this->read($row['original_pathway_name'])
            );
        }

        // Reads attributes
        $result = $this->query('SELECT name, value FROM pathway_attribute WHERE pathway_name = :pathway_name', [
            ':pathway_name' => $pathway_name
        ]);
        foreach ($result as $record) {
            $pattern = '/(doi:)\s*([^\/]*)\/([^\s]*)\.\s/';
            $record['value'] = preg_replace($pattern, '<a href="https://doi.org/$2/$3">$0</a>', $record['value']);

            $record['value'] = preg_replace(
                '/https:\/\/reactome.org\/content\/detail\/([^\s<]*)/',
                '<a href=https://reactome.org/content/detail/$1>$0</a><br>',
                $record['value']
            );

            $pathway->addAttribute($record['name'], $record['value']);
        }

        return $pathway;
    }
    
    
    /**
     * Insert association between a pathway and a mitochondrial process.
     *
     * @param \Mitopaths\Model\Pathway $pathway Pathway
     * @param \Mitopaths\Model\MitochondrialProcess $mitochondrial_process Mitochondrial process
     * @return $this This mapper
     */
    private function insertMitochondrialProcess($pathway, $mitochondrial_process) {
        $this->query('INSERT INTO pathway_mitochondrial_process(pathway_name, mitochondrial_process_name) VALUES(:pathway_name, :mitochondrial_process_name)', [
            ':pathway_name' => $pathway->getName(),
            ':mitochondrial_process_name' => $mitochondrial_process->getName()
        ]);
        
        return $this;
    }
    
    /**
     * Insert a theorem belonging to a pathway.
     *
     * @param \Mitopaths\Model\Pathway $pathway Owner pathway
     * @param int $step Step number, or 0 for main theorem
     * @param \Mitopaths\Model\Theorem $theorem Theorem to insert
     * @return $this This mapper
     */
    private function insertTheorem(\Mitopaths\Model\Pathway $pathway, int $step, \Mitopaths\Model\Theorem $theorem) {
        $visitor = new \Mitopaths\Model\Expression\Visitor\Export();
        
        $theorem->getHead()->accept($visitor);
        $head = $visitor->getResult();
        
        $visitor->reset();
        $theorem->getBody()->accept($visitor);
        $body = $visitor->getResult();
        
        $this->query('INSERT INTO theorem(pathway_name, step, head, body) VALUES(:pathway_name, :step, :head, :body)', [
            ':pathway_name' => $pathway->getName(),
            ':step' => $step,
            ':head' => $head,
            ':body' => $body
        ]);
        
        return $this;
    }


    /**
     * Insert an attribute of a pathway.
     *
     * @param \Mitopaths\Model\Pathway $pathway Owner pathway
     * @param string $name Name
     * @param string $value Value
     * @return $this This mapper
     */
    private function insertAttribute($pathway, $name, $value) {
        $this->query('INSERT INTO pathway_attribute(pathway_name, name, type, value) VALUES(:pathway_name, :name, "string", :value)', [
            ':pathway_name' => $pathway->getName(),
            ':name' => $name,
            ':value' => $value
        ]);
    }
}
