<?php
/**
 * Pathways controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths
 */
namespace Mitopaths\Controller;

/**
 * Pathways controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class Pathways extends Controller {
    /**
     * Creates a new pathway.
     *
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function post($binders = []) {
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
        
        $pathway_name = $_REQUEST['name'];
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
        
        
        $solr_mapper = new \Mitopaths\DataMapper\Solr();
        $pathway_mapper = new \Mitopaths\DataMapper\Pathway;
        
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

        // Reads attribute
        foreach ($_REQUEST['attributes'] as $key => $value) {
            $pathway->addAttribute($key, $value);
        }
        
        $pathway_mapper->create($pathway);
        $solr_mapper->create($pathway);
        $this->view('format/json', ['data' => true]);
        
        return $this;
    }
}
