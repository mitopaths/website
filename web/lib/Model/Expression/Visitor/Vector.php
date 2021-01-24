<?php
/**
 * Expression to array exporter.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model\Expression\Visitor
 */
namespace Mitopaths\Model\Expression\Visitor;

/**
 * Expression to array exporter.
 *
 * This class follows the Visitor Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model\Expression\Visitor
 */
class Vector implements \Mitopaths\Model\Expression\VisitorInterface {
    /**
     * Visits an expression.
     *
     * @param \Mitopaths\Model\Expression\AbstractConjunction $subject Expression
     * @return array Result
     */
    public function visit(\Mitopaths\Model\Expression\AbstractConjunction $subject) {
        if ($subject instanceof \Mitopaths\Model\Expression\AbstractMoleculeDecorator) {
            return $this->visitAbstractMoleculeDecorator($subject);
        }
        elseif ($subject instanceof \Mitopaths\Model\Expression\Interaction) {
            return $this->visitInteraction($subject);
        }
        elseif ($subject instanceof \Mitopaths\Model\Expression\Conjunction) {
            return $this->visitConjunction($subject);
        }
    }
    
    
    /**
     * Visits an abstract molecule decorator.
     *
     * @param \Mitopaths\Model\Expression\AbstractMoleculeDecorator $subject Expression
     * @return array Result
     */
    private function visitAbstractMoleculeDecorator($subject) {
        $molecule = $subject->getMolecule();
        
        $type = 'molecule';
        if ($molecule instanceof \Mitopaths\Model\Protein) {
            $type = 'protein';
        }
        elseif ($molecule instanceof \Mitopaths\Model\MutatedProtein) {
            $type = 'mutated_protein';
        }
        
        $data = [
            '_type' => $type,
            'name' => $molecule->getName(),
            'position' => $subject->getPosition()
        ];
        
        return array_merge($data, $subject->getAttributesAsArray());
    }
    
    /**
     * Visits an interaction.
     *
     * @param \Mitopaths\Model\Expression\Interaction $subject Interaction
     * @return array Result
     */
    private function visitInteraction($subject) {
        $components = array_map([$this, 'visit'], $subject->getComponentsAsArray());
        
        $data = [
            '_type' => 'interaction',
            'position' => $subject->getPosition(),
            'components' => $components
        ];
        
        return array_merge($data, $subject->getAttributesAsArray());
    }
    
    /**
     * Visits an conjunction.
     *
     * @param \Mitopaths\Model\Expression\Conjunction $subject Conjunction
     * @return array Result
     */
    private function visitConjunction($subject) {
        $components = array_map([$this, 'visit'], $subject->getComponentsAsArray());
        
        return [
            '_type' => 'conjunction',
            'components' => $components
        ];
    }
}