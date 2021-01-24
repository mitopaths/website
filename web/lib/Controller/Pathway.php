<?php
/**
 * Pathway controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Pathway controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Pathway extends Controller {
    /**
     * Updates a pathway.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function put($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        $user->requireRole('editor');
        
        $this->requiredParameters($_REQUEST, [
            'type',
            'name',
            'contributor',
            'theorem_body',
            'theorem_head',
            'step_body',
            'step_head'
        ]);
        $this->optionalParameters($_REQUEST, [
            'mitochondrial_processes' => [],
            'attributes' => []
        ]);
        if ($_REQUEST['type'] === 'mutated_pathway') {
            $this->requiredParameters($_REQUEST, ['original_pathway']);
        }
        
        // Reads data
        $molecule_mapper = new \Mitopaths\DataMapper\AbstractMolecule();
        $parser = new \Mitopaths\Model\Expression\Parser\Parser($molecule_mapper);
        $mitochondrial_process_mapper = new \Mitopaths\DataMapper\MitochondrialProcess();        
        $solr_mapper = new \Mitopaths\DataMapper\Solr();
        $pathway_mapper = new \Mitopaths\DataMapper\Pathway;
        
        $pathway_name = str_replace(['---0', '---1'], ['/', '+'], $_REQUEST['name']);
        $pathway_contributor = $_REQUEST['contributor'];
        
        $theorem = new \Mitopaths\Model\Theorem(
            $parser->parse($_REQUEST['theorem_head']),
            $parser->parse($_REQUEST['theorem_body'])
        );
        
        $steps = [];
        for ($i = 0; $i < count($_REQUEST['step_head']); ++$i) {
            $head_expression = $_REQUEST['step_head'][$i];
            $body_expression = $_REQUEST['step_body'][$i];
            
            $steps[] = new \Mitopaths\Model\Theorem(
                $parser->parse($head_expression),
                $parser->parse($body_expression)
            );
        }
        
        $mitochondrial_processes = [];
        foreach ($_REQUEST['mitochondrial_processes'] as $name) {
            $mitochondrial_processes[] = $mitochondrial_process_mapper->read($name);
        }

        
        // Saves data
        if ($_REQUEST['type'] === 'pathway') {
            $pathway = new \Mitopaths\Model\Pathway(
                $pathway_name,
                $pathway_contributor,
                $theorem,
                $steps,
                $mitochondrial_processes
            );
        }
        elseif ($_REQUEST['type'] === 'mutated_pathway') {
            $original_pathway = $pathway_mapper->read($_REQUEST['original_pathway']);
            
            $pathway = new \Mitopaths\Model\MutatedPathway(
                $pathway_name,
                $pathway_contributor,
                $theorem,
                $steps,
                $mitochondrial_processes,
                $original_pathway
            );
        }

        // Updates attributes
        foreach ($_REQUEST['attributes'] as $key => $value) {
            $pathway->addAttribute($key, $value);
        }

        $pathway_mapper->update($pathway);
        $solr_mapper->update($pathway);

        if (isset($_FILES)) {
            $files = array_filter($_FILES['image']['tmp_name']);
            $types = array_filter($_FILES['image']['type']);
            if (!empty($files)) {
                $dbh = new \PDO('mysql:dbname=mitopaths;host=localhost', 'mitopaths', 'uX<z/f54m=[4x9c');
                $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

                $sth = $dbh->prepare('DELETE FROM pathway_attribute WHERE pathway_name = :pathway_name AND name LIKE :name');
                $sth->execute([
                    ':pathway_name' => $pathway_name,
                    ':name' => 'image-%'
                ]);

                $sth = $dbh->prepare('INSERT INTO pathway_attribute(pathway_name, name, type, value) VALUES(:pathway_name, :name, :type, :value)');
                for ($i = 0; $i < count($files); ++$i) {
                    $file = $files[$i];
                    $content = file_get_contents($file);
                    $sth->execute([
                        ':pathway_name' => $pathway_name,
                        ':name' => sprintf("image-%04d", $i),
                        ':type' => $types[$i],
                        ':value' => $content
                    ]);
                }
            }
        }
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
    
    /**
     * Deletes a pathway.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function delete($binders = []) {
        \Mitopaths\Session::requireAuthentication();
        $user = \Mitopaths\Session::getUser();
        $user->requireRole('editor');
        
        $this->requiredParameters($_REQUEST, ['name']);
        
        $name = $_REQUEST['name'];
        $pathway_mapper = new \Mitopaths\DataMapper\Pathway();
        $solr_mapper = new \Mitopaths\DataMapper\Solr();
        
        $pathway = $pathway_mapper->read($name);
        $pathway_mapper->delete($pathway);
        $solr_mapper->delete($pathway);
        
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
}
