<?php
/**
 * Solr mapper.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\DataMapper
 */
namespace Mitopaths\DataMapper;

/**
 * Functionality mapper.
 *
 * This class follows the Facade and the Data Mapper Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\DataMapper
 */
class Solr {
    /** @var string $host Solr host. */
    private $host;
    
    /** @var int $port Port on which Solr is listening. */
    private $port;
    
    /** @var string $core_name Solr core's name. */
    private $core_name;
    
    
    /**
     * Default constructor,
     *
     * Reads infomration from config file.
     */
    public function __construct() {
        $config = parse_ini_file('config.ini', true);
        $this->host = $config['solr']['host'];
        $this->port = $config['solr']['port'];
        $this->core_name = $config['solr']['core_name'];
    }
    
    
    /**
     * Creates a new entity.
     *
     * @param object $object Entity to create
     * @return $this This mapper
     */
    public function create($object): Solr {
        if ($object instanceof \Mitopaths\Model\Molecule) {
            $this->createMolecule($object);
        }
        elseif ($object instanceof \Mitopaths\Model\Protein) {
            $this->createProtein($object);
        }
        elseif ($object instanceof \Mitopaths\Model\MutatedProtein) {
            $this->createMutatedProtein($object);
        }
        
        elseif ($object instanceof \Mitopaths\Model\MitochondrialProcess) {
            $this->createMitochondrialProcess($object);
        }
        
        elseif ($object instanceof \Mitopaths\Model\MutatedPathway) {
            $this->createMutatedPathway($object);
        }
        elseif ($object instanceof \Mitopaths\Model\Pathway) {
            $this->createPathway($object);
        }
        
        return $this;
    }
    
    /**
     * Performs a query against Solr.
     *
     * @param string $query Query terms
     * @param array $filters Array of filters
     * @param int $page Page number (starting from 0)
     * @param int $page_size Number of results per page
     * @param array $search_fields Array of fields to be used for research (uses Solr's default if empty)
     * @param array $fields Array of fields to return (uses Solr's default if empty)
     * @return array Associative array of results
     */
    public function read(
        string $query,
        array $filters = [],
        int $page = 0,
        int $page_size = 10,
        array $search_fields = [],
        array $fields = []
    ): array {
        $parameters = [
            'q' => $query,
            'fq' => $filters,
            'start' => $page * $page_size,
            'rows' => $page_size
        ];
        if (!empty($search_fields)) {
            $parameters['qf'] = implode(' ', $search_fields);
        }
        if (!empty($fields)) {
            $parameters['fl'] = implode(',', $fields);
        }
        
        $data = $this->receiveData($parameters);
        
        // Converts Solr results into a more conventient format
        $result = [];
        $result['q'] = $query;
        $result['response_time'] = $data['responseHeader']['QTime'];
        $result['results'] = $data['response']['numFound'];
        $result['page'] = $page;
        $result['page_size'] = $page_size;
        
        $result['items'] = [];
        foreach ($data['response']['docs'] as $doc) {
            $doc['_highlighting'] = [];
            foreach ($data['highlighting'][$doc['id']] as $field => $values) {
                $filtered_values = [];
                foreach ($values as $value) {
                    if (strpos($value, '</span>') !== false) {
                        $filtered_values[] = $value;
                    }
                }
                
                if (!empty($filtered_values)) {
                    $field = str_replace('_highlighting', '', $field);
                    $doc['_highlighting'][$field] = $filtered_values;
                }
            }
            
            $result['items'][] = $doc;
        }
        
        $result['facet_fields'] = [];
        foreach ($data['facet_counts']['facet_fields'] as $field => $values) {
            $result['facet_fields'][$field] = [];
            for ($i = 0; $i < count($values); $i += 2) {
                $name = $values[$i];
                $count = $values[$i + 1];
                $result['facet_fields'][$field][$name] = $count;
            }
        }
        
        return $result;
    }
    
    /**
     * Updates an entity.
     *
     * Due to Solr's behavior, this is an alias for Solr::create.
     *
     * @param object $object Entity to update
     * @return $this This mapper
     */
    public function update($object): Solr {
        return $this->create($object);
    }
    
    /**
     * Deletes an entity from Solr.
     *
     * @param object $object Entity to delete
     * @return $this This mapper
     */
    public function delete($object): Solr {
        $this->deleteData($this->computeId($object));
        
        return $this;
    }
    
    
    /**
     * Returns URL of Solr core.
     *
     * @return string URL of Solr core
     */
    private function getUrl(): string {
        return "http://" . $this->host .":" . $this->port
            . "/solr/" . $this->core_name;
    }
    
    
    /**
     * Creates a molecule.
     *
     * @param \Mitopaths\Model\Molecule $molecule Molecule to create
     * @return $this This mapper
     */
    private function createMolecule(\Mitopaths\Model\Molecule $molecule): Solr {
        return $this->sendData([
            'name' => $molecule->getName(),
            'type' => 'molecule',
            'description' => $molecule->getDescription(),
        ]);
    }
    
    /**
     * Creates a protein.
     *
     * @param \Mitopaths\Model\Protein $protein Protein to create
     * @return $this This mapper
     */
    private function createProtein(\Mitopaths\Model\Protein $protein): Solr {
        return $this->sendData([
            'name' => $protein->getName(),
            'type' => 'protein',
            'description' => $protein->getDescription()
        ]);
    }
    
    /**
     * Creates a mutated protein.
     *
     * @param \Mitopaths\Model\MutatedProtein $mutated_protein MutatedProtein to create
     * @return $this This mapper
     */
    private function createMutatedProtein(\Mitopaths\Model\MutatedProtein $mutated_protein): Solr {
        return $this->sendData([
            'name' => $mutated_protein->getName(),
            'type' => 'mutated_protein',
            'description' => $mutated_protein->getDescription(),
            'original_protein' => $mutated_protein->getOriginalProtein()->getName()
        ]);
    }
    
    /**
     * Creates a mitochondrial process.
     *
     * @param \Mitopaths\Model\MitochondrialProcess $mitochondrial_process Mitochondrial process to create
     * @return $this This mapper
     */
    private function createMitochondrialProcess(\Mitopaths\Model\MitochondrialProcess $mitochondrial_process): Solr {
        return $this->sendData([
            'name' => $mitochondrial_process->getName(),
            'type' => 'category',
            'description' => $mitochondrial_process->getDescription()
        ]);
    }
    
    /**
     * Creates a pathway.
     *
     * @param \Mitopaths\Model\Pathway $pathway Pathway to create
     * @return $this This mapper
     */
    private function createPathway(\Mitopaths\Model\Pathway $pathway) {
        return $this->sendData([
            'name' => $pathway->getName(),
            'type' => 'pathway',
            'theorem' => $this->theoremToString($pathway->getTheorem()),
            'steps' => array_map([$this, 'theoremToString'], $pathway->getStepsAsArray()),
            'category' => array_map([$this, 'categoryToString'], $pathway->getMitochondrialProcessesAsArray())
        ]);
    }
    
    /**
     * Creates a mutated pathway.
     *
     * @param \Mitopaths\Model\MutatedPathway $pathway Mutated pathway to create
     * @return $this This mapper
     */
    private function createMutatedPathway(\Mitopaths\Model\MutatedPathway $pathway) {
        return $this->sendData([
            'name' => $pathway->getName(),
            'type' => 'mutated_pathway',
            'theorem' => $this->theoremToString($pathway->getTheorem()),
            'steps' => array_map([$this, 'theoremToString'], $pathway->getStepsAsArray()),
            'category' => array_map([$this, 'categoryToString'], $pathway->getMitochondrialProcessesAsArray()),
            'original_pathway' => $pathway->getOriginalPathway()->getName()
        ]);
    }
    
    /**
     * Converts a theorem to a string.
     *
     * @param \Mitopaths\Model\Theorem $theorem Theorem to convert
     * @return string Theorem converted to string
     */
    private function theoremToString(\Mitopaths\Model\Theorem $theorem): string {
        $visitor = new \Mitopaths\Model\Expression\Visitor\SimpleExport();

        $theorem->getHead()->accept($visitor);
        $head = $visitor->getResult();

        $visitor->reset();
        $theorem->getBody()->accept($visitor);
        $body = $visitor->getResult();

        return $body . " &rArr; " . $head;
    }
    
    /**
     * Converts a mitochondrial process to string.
     *
     * @param \Mitopaths\Model\MitochondrialProcess $category Mitochondrial process to convert
     * @return string Mitochondrial process converted to string
     */
    private function categoryToString(\Mitopaths\Model\MitochondrialProcess $category): string {
        return $category->getName();
    }
    
    /**
     * Returns identifier of an entity.
     *
     * @param object $object Entity
     * @return string Identifier of given entity
     */
    private function computeId($object) {
        if ($object instanceof \Mitopaths\Model\Molecule) {
            return 'molecule_' . md5($object->getName());
        }
        elseif ($object instanceof \Mitopaths\Model\Protein) {
            return 'protein_' . md5($object->getName());
        }
        elseif ($object instanceof \Mitopaths\Model\MutatedProtein) {
            return 'mutated_protein_' . md5($object->getName());
        }
        
        elseif ($object instanceof \Mitopaths\Model\MitochondrialProcess) {
            return 'category_' . md5($object->getName());
        }
        
        elseif ($object instanceof \Mitopaths\Model\MutatedPathway) {
            return 'mutated_pathway_' . md5($object->getName());
        }
        elseif ($object instanceof \Mitopaths\Model\Pathway) {
            return 'pathway_' . md5($object->getName());
        }
        
        throw new \Exception("Unknown type of object");
    }
    
    
    /**
     * Sends data to create or update a record.
     *
     * @param array $data Associative array of data to send
     * @return $this This mapper
     * @throw \Exception If cannot send data or data was not accepted by Solr
     */
    private function sendData(array $data) {
        $data['id'] = $data['type'] . '_' . md5($data['name']);
        $data = [
            'add' => [
                'doc' => $data,
                'commitWithin' => 1000
            ]
            
        ];
        $data = json_encode($data);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl() . "/update/");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json; charset=utf-8']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new \Exception("Error while sending data to Solr server: " . curl_error($ch));
        }
        curl_close($ch);
        
        $result = json_decode($result, true);
        if ($result['responseHeader']['status'] !== 0) {
            throw new \Exception("Error while sending data to Solr server: " . $result['error']['msg']);
        }
            
        return $this;
    }
    
    /**
     * Runs a query.
     *
     * @param array $data Associative array of data to build the query
     * @return $this This mapper
     * @throw \Exception If cannot receive data or data was not accepted by Solr
     */
    private function receiveData(array $data) {
        $query_string = http_build_query($data, null, '&');
        $query_string = preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $query_string);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl() . "/select/?" . $query_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new \Exception("Error while retrieving data from Solr server: " . curl_error($ch));
        }
        curl_close($ch);
        
        $result = json_decode($result, true);
        if ($result['responseHeader']['status'] !== 0) {
            throw new \Exception("Error while retrieving data from Solr server: " . $result['error']['msg']);
        }
            
        return $result;
    }
    
    
    /**
     * Deletes a record
     *
     * @param string $id Identifier of the record to delete
     * @return $this This mapper
     * @throw \Exception If cannot delete data or request was not accepted by Solr
     */
    private function deleteData(string $id) {
        $data = json_encode([
            'delete' => [
                'id' => $id
            ]
        ]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl() . "/update/?commit=true");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json; charset=utf-8']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new \Exception("Error while deleting data from Solr server: " . curl_error($ch));
        }
        curl_close($ch);
        
        $result = json_decode($result, true);
        if ($result['responseHeader']['status'] !== 0) {
            throw new \Exception("Error while deleting data from Solr server: " . $result['error']['msg']);
        }
            
        return $this;
    }
}
