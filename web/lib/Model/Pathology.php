<?php
/**
 * Pathology.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model
 */
namespace Mitopaths\Model;

/**
 * Pathology.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model
 */
class Pathology {
    /** @var string $name Name of this pathology. */
    private $name;
    
    /** @var string $description Description of this pathology. */
    private $description;
    
    
    /**
     * Constructor.
     *
     * @param string $name Name of this pathology
     * @param string $description Description of this pathology
     */
    public function __construct(string $name, string $description) {
        $this->name = $name;
        $this->description = $description;
    }
    
    
    /**
     * Returns name of this pathology.
     *
     * @return string Name of this pathology
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * Returns description of this pathology.
     *
     * @return string Description of this pathology
     */
    public function getDescription(): string {
        return $this->description;
    }
    
    
    /**
     * Sets name of this pathology.
     *
     * @param string $name Name of this pathology
     * @return $this This pathology
     */
    public function setName(string $name): AbstractMolecule {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Sets description of this pathology.
     *
     * @param string $description Description of this pathology
     * @return $this This pathology
     */
    public function setDescription(string $description): AbstractMolecule {
        $this->description = $description;
        return $this;
    }
}