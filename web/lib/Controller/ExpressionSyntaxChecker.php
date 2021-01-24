<?php
/**
 * Expression validator controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Expression validator controller.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
class ExpressionSyntaxChecker extends Controller {
    /**
     * Validates an expression.
     *
     * Displaies an 'OK' response if expression is syntactically correct, a descriptive error othwerwise.
     * 
     * @param array $binders Associative array of binders
     * @return $this This controller
     */
    public function get($binders = []) {
        $this->requiredParameters($_REQUEST, ['expression']);
        
        $molecule_mapper = new \Mitopaths\DataMapper\AbstractMolecule();
        $parser = new \Mitopaths\Model\Expression\Parser\Parser($molecule_mapper);
        $response = [
            'status' => 'OK'
        ];
        
        try {
            $parser->parse($_REQUEST['expression']);
        }
        catch (\Mitopaths\Model\Expression\Parser\SyntaxError $e) {
            $response['status'] = 'ERROR';
            $response['error'] = $e->getMessage();
        }
        catch (\Exception $e) {
            $response['status'] = 'ERROR';
            $response['error'] = 'Could not parse expression.';
        }
        
        $this->view('format/json', ['data' => $response]);
        
        return $this;
    }
}