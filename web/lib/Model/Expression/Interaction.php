<?php
/**
 * Interaction.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model\Expression
 */
namespace Mitopaths\Model\Expression;

/**
 * Interaction.
 *
 * This class follows the Visitor and the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model\Expression
 */
class Interaction extends AbstractInteraction {
    /** @var array $components Components in this conjunction. */
    private $components;
    
    
    /**
     * Constructor.
     *
     * @param array $components Components in this conjunction.
     * @param int $position Position code
     * @param array Associative array of additional attributes
     */
    public function __construct(
        array $components,
        int $position = AbstractInteraction::NA,
        array $attributes = []
    ) {
        $this->components = $components;
        $this->setPosition($position);
        $this->setAttributes($attributes);
    }
    
    
    /**
     * Returns components in this conjuction.
     *
     * @return array Components in this conjunction
     */
    public function getComponentsAsArray(): array {
        return $this->components;
    }
    
    
    /**
     * Adds a component to this conjunction.
     *
     * @param AbstractInteraction $component Component to add
     * @return $this This conjunction
     */
    public function addComponent(AbstractInteraction $component): Conjunction {
        $this->components[] = $component;
        
        return $this;
    }
    
    
    /**
     * Accepts a visitor.
     *
     * @param VisitorInterface $visitor Visitor to accept
     * @return mixed Result of the visit
     */
    public function accept(VisitorInterface $visitor) {
        return $visitor->visit($this);
    }
}