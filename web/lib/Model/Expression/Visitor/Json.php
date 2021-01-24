<?php
/**
 * JSON expression exporter.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model\Expression\Visitor
 */
namespace Mitopaths\Model\Expression\Visitor;

/**
 * JSON exporter.
 *
 * This class follows the Visitor Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model\Expression\Visitor
 */
class Json implements \Mitopaths\Model\Expression\VisitorInterface {
    /** @var string $result Resulting string. */
    private $result;
    
    
    /**
     * Default constructor.
     */
    public function __construct() {
        $this->result = "";
    }
    
    
    /**
     * Returns result of the visit.
     *
     * @return string Result
     */
    public function getResult(): string {
        return $this->result;
    }
    
    
    /**
     * Resets visitor's state.
     *
     * @return $this This visitor
     */
    public function reset(): Json {
        $this->result = "";
        
        return $this;
    }
    
    
    /**
     * Visits an expression.
     *
     * @param \Mitopaths\Model\Expression\AbstractConjunction $subject Expression
     */
    public function visit(\Mitopaths\Model\Expression\AbstractConjunction $subject) {
        $vector_visitor = new Vector();
        
        $subject->accept($vector_visitor);
        
        $this->result = json_encode($vector_visitor->getResult());
    }
}