<?php
/**
 * Molecule.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model\Expression
 */
namespace Mitopaths\Model\Expression;

/**
 * Molecule.
 *
 * Decorator for a generic molecule (molecule, protein...).
 *
 * This class follows the Decorator, the Visitor and the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model\Expression
 */
class AbstractMoleculeDecorator extends AbstractInteraction {
    /** @var \Mitopaths\Model\AbstractMolecule $molecule Molecule to decorate. */
    private $molecule;
    
    
    /**
     * Constructor.
     * 
     * @param \Mitopaths\Model\AbstractMolecule $molecule Molecule to decorate.
     * @param int $position Position code
     * @param array Associative array of additional attributes
     */
    public function __construct(
        \Mitopaths\Model\AbstractMolecule $molecule,
        int $position = AbstractInteraction::NA,
        array $attributes = []
    ) {
        $this->molecule = $molecule;
        $this->setPosition($position);
        $this->setAttributes($attributes);
    }
    
    
    /**
     * Returns molecule to decorate.
     *
     * @return \Mitopaths\Model\AbstractMolecule Molecule to decorate
     */
    public function getMolecule(): \Mitopaths\Model\AbstractMolecule {
        return $this->molecule;
    }
    
    
    /**
     * Sets molecule to decorate.
     *
     * @param \Mitopaths\Model\AbstractMolecule $molecule Molecule to decorate
     * @return $this
     */
    public function setMolecule(AbstractMolecule $molecule): AbstractMoleculeDecorator {
        $this->molecule = $molecule;
        
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