<?php
/**
 * Export visitor.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model\Expression\Visitor
 */
namespace Mitopaths\Model\Expression\Visitor;

/**
 * Export visitor.
 *
 * This class follows the Visitor Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model\Expression\Visitor
 */
class Export implements \Mitopaths\Model\Expression\VisitorInterface {
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
    public function reset(): Export {
        $this->result = "";
        
        return $this;
    }
    
    
    /**
     * Visits an expression.
     *
     * @param \Mitopaths\Model\Expression\AbstractConjunction $subject Expression
     */
    public function visit(\Mitopaths\Model\Expression\AbstractConjunction $subject) {
        if ($subject instanceof \Mitopaths\Model\Expression\AbstractMoleculeDecorator) {
            $this->visitAbstractMoleculeDecorator($subject);
        }
        elseif ($subject instanceof \Mitopaths\Model\Expression\Interaction) {
            $this->visitInteraction($subject);
        }
        elseif ($subject instanceof \Mitopaths\Model\Expression\Conjunction) {
            $this->visitConjunction($subject);
        }
    }
    
    
    /**
     * Visits an abstract molecule decorator.
     *
     * @param \Mitopaths\Model\Expression\AbstractMoleculeDecorator $subject Expression
     */
    private function visitAbstractMoleculeDecorator($subject) {
        $attributes = $subject->getAttributesAsArray();
        
        $this->result .= "\""
            . $subject->getMolecule()->getName()
            . "\""
            . " position:" . $subject->getPosition();
        
        foreach ($attributes as $key => $value) {
            $this->result .= " \"" . $key . "\":\"" . $value . "\"";
        }
    }
    
    /**
     * Visits an interaction.
     *
     * @param \Mitopaths\Model\Expression\Interaction $subject Interaction
     */
    private function visitInteraction($subject) {
        $components = $subject->getComponentsAsArray();
        $attributes = $subject->getAttributesAsArray();
        
        $this->result .= "(";
        for ($i = 0; $i < count($components); ++$i) {
            $components[$i]->accept($this);
            if ($i + 1 < count($components)) {
                $this->result .= ",";
            }
        }
        
        $this->result .= ") position: " . $subject->getPosition();
        
        foreach ($attributes as $key => $value) {
            $this->result .= " \"" . $key . "\":\"" . $value . "\"";
        }
    }
    
    /**
     * Visits an conjunction.
     *
     * @param \Mitopaths\Model\Expression\Conjunction $subject Conjunction
     */
    private function visitConjunction($subject) {
        $components = $subject->getComponentsAsArray();
        
        $this->result .= "{";
        for ($i = 0; $i < count($components); ++$i) {
            $components[$i]->accept($this);
            if ($i + 1 < count($components)) {
                $this->result .= ",";
            }
        }
        
        $this->result .= "}";
    }
}