<?php
require_once '../web/lib/autoloader.php';

class stubMapper {
    public function read(string $name) {
        return new \Mitopaths\Model\Molecule($name, "");
    }
}

$config = parse_ini_file('../config.ini', true);

function solr_query($data) {
    global $config;
    $data = json_encode($data);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://" . $config['solr']['host'] . ":" . $config['solr']['port'] . "/solr/" . $config['solr']['core_name'] . "/update/?commit=true");
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
        throw new \Exception("Error while querying Solr server: " . curl_error($ch));
    }
    curl_close($ch);

    $result = json_decode($result, true);
    if ($result['responseHeader']['status'] !== 0) {
        throw new \Exception("Error while querying Solr server: " . $result['error']['msg']);
    }

    return $result;
}



function get_database_connection() {
    global $config;
    
    $dbh = new \PDO(
        'mysql:host=' . $config['database_server']['host'] . ';dbname=' . $config['database_server']['name'] . ';charset=utf8', 
        $config['database_server']['user'],
        $config['database_server']['password']
    );
    $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(\PDO::ATTR_PERSISTENT, true);
    
    return $dbh;
}


    
function theorem_to_string($head, $body): string {
    $molecule_mapper = new stubMapper();
    $parser = new \Mitopaths\Model\Expression\Parser\Parser($molecule_mapper);
    $visitor = new \Mitopaths\Model\Expression\Visitor\SimpleExport();
    
    $head = $parser->parse($head);
    $head->accept($visitor);
    $head = $visitor->getResult();

    $visitor->reset();
    $body = $parser->parse($body);
    $body->accept($visitor);
    $body = $visitor->getResult();

    return $body . " &rArr; " . $head;
}



function sync_molecules() {
    $dbh = get_database_connection();
    
    $result = $dbh->query('SELECT *, abstract_molecule.name AS molecule_name, molecule_attribute.name AS attr_name FROM (abstract_molecule JOIN molecule ON abstract_molecule.name = molecule.abstract_molecule_name) LEFT JOIN molecule_attribute ON abstract_molecule.name = molecule_attribute.abstract_molecule_name');
    
    $data = [];
    foreach ($result as $record) {
        $data[$record['molecule_name']]['id'] = 'molecule_' . md5($record['molecule_name']);
        $data[$record['molecule_name']]['name'] = $record['molecule_name'];
        $data[$record['molecule_name']]['type'] = 'molecule';
        $data[$record['molecule_name']]['description'] = !empty($record['description']) ? $record['description'] : "";
        if (!empty($record['value'])) {
            $data[$record['molecule_name']][$record['attr_name'] . '_attr'] = $record['value'];
        }
    }
    
    solr_query([
        'delete' => [
            'query' => 'type:molecule'
        ]
    ]);
    
    solr_query([
        'add' => array_values($data)
    ]
    );
}



function sync_proteins() {
    $dbh = get_database_connection();
    
    $result = $dbh->query('SELECT *, abstract_molecule.name AS molecule_name, molecule_attribute.name AS attr_name FROM (abstract_molecule JOIN protein ON abstract_molecule.name = protein.abstract_molecule_name) LEFT JOIN molecule_attribute ON abstract_molecule.name = molecule_attribute.abstract_molecule_name');
    
    $data = [];
    foreach ($result as $record) {
        $data[$record['molecule_name']]['id'] = 'protein_' . md5($record['molecule_name']);
        $data[$record['molecule_name']]['name'] = $record['molecule_name'];
        $data[$record['molecule_name']]['type'] = 'protein';
        $data[$record['molecule_name']]['description'] = !empty($record['description']) ? $record['description'] : "";
        if (!empty($record['value'])) {
            $data[$record['molecule_name']][$record['attr_name'] . '_attr'] = $record['value'];
        }
    }
    
    solr_query([
        'delete' => [
            'query' => 'type:protein'
        ]
    ]);
    
    solr_query([
        'add' => array_values($data)
    ]
    );
}



function sync_mutated_proteins() {
    $dbh = get_database_connection();
    
    $result = $dbh->query('SELECT *, abstract_molecule.name AS molecule_name, molecule_attribute.name AS attr_name FROM (abstract_molecule JOIN mutated_protein ON abstract_molecule.name = mutated_protein.abstract_molecule_name) LEFT JOIN molecule_attribute ON abstract_molecule.name = molecule_attribute.abstract_molecule_name');
    
    $data = [];
    foreach ($result as $record) {
        $data[$record['molecule_name']]['id'] = 'mutated_protein_' . md5($record['molecule_name']);
        $data[$record['molecule_name']]['name'] = $record['molecule_name'];
        $data[$record['molecule_name']]['type'] = 'mutated_protein';
        $data[$record['molecule_name']]['original_protein'] = $record['original_protein_name'];
        $data[$record['molecule_name']]['description'] = !empty($record['description']) ? $record['description'] : "";
        if (!empty($record['value'])) {
            $data[$record['molecule_name']][$record['attr_name'] . '_attr'] = $record['value'];
        }
    }
    
    solr_query([
        'delete' => [
            'query' => 'type:mutated_protein'
        ]
    ]);
    
    solr_query([
        'add' => array_values($data)
    ]
    );
}



function sync_categories() {
    $dbh = get_database_connection();
    
    $result = $dbh->query('SELECT *FROM mitochondrial_process');
    
    $data = [];
    foreach ($result as $record) {
        $data[] = [
            'id' => 'category_' . md5($record['name']),
            'name' => $record['name'],
            'type' => 'category',
            'description' => !empty($record['description']) ? $record['description'] : ""
        ];
    }
    
    solr_query([
        'delete' => [
            'query' => 'type:category'
        ]
    ]);
    
    solr_query([
        'add' => $data
    ]
    );
}






function sync_pathways() {
    $dbh = get_database_connection();
    
    $result = $dbh->query('SELECT * FROM pathway JOIN theorem ON pathway.name = theorem.pathway_name');
    
    $data = [];
    $i = 0;
    foreach ($result as $record) {
        $name = $record['name'];
        $type = empty($record['original_pathway_name']) ? 'pathway' : 'mutated_pathway';
        
        $data[$name]['id'] = $type . '_' . md5($name);
        $data[$name]['name'] = $name;
        $data[$name]['type'] = $type;
        if ($type === 'mutated_pathway') {
            $data[$name]['original_pathway'] = $record['original_pathway_name'];
        }
        if ($record['step'] == 0) {
            $data[$name]['theorem'] = theorem_to_string($record['head'], $record['body']);
        }
        else {
            $data[$name]['steps'][] = theorem_to_string($record['head'], $record['body']);
        }
        
        echo "Done: " . (++$i) . "\n";
    }
    
    
    $result = $dbh->query('SELECT * FROM pathway_mitochondrial_process');
    foreach ($result as $record) {
        if (!array_key_exists($record['pathway_name'], $data) || !array_key_exists('id', $data[$record['pathway_name']])) {
            continue;
        }
        $data[$record['pathway_name']]['category'][] = $record['mitochondrial_process_name'];
    }
    
    //var_dump($data);
    
    echo "Done parsing.\n";
    solr_query([
        'delete' => [
            'query' => 'type:(pathway OR mutated_pathway)'
        ]
    ]);
    echo "Old data deleted.\n";
    $r = solr_query([
        'add' => array_values($data)
        ]
    );
    echo "Done.\n";
    var_dump($r);
}













sync_molecules();
sync_proteins();
sync_mutated_proteins();
sync_categories();
sync_pathways();
