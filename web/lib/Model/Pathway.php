<?php
/**
 * Pathway.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model
 */
namespace Mitopaths\Model;

/**
 * Pathway.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model
 */
class Pathway {
    /** @var string $name Name of this pathway. */
    private $name;
    
    /** @var string $contributor Contributor of this pathway. */
    private $contributor;
    
    /** @var Theorem $theorem Main theorem of this pathway. */
    private $theorem;
    
    /** @var array $steps Array of steps of this pathway. */
    private $steps;
    
    /** @var array $mitochondrial_processes Array of mitochondrial processes involving this pathway. */
    private $mitochondrial_processes;

    /** @var array $attributes Array of pathway attributes. */
    private $attributes;
    
    
    /**
     * Constructor.
     *
     * @param string $name Name of this pathway
     * @param string $contributor Contributor of this pathway
     * @param Theorem $theorem Main theorem of this pathway
     * @param array $steps Array of steps in this pathway
     * @param array $mitochondrial_processes Array of mitochondrial processes
     */
    public function __construct(
        string $name,
        string $contributor,
        Theorem $theorem,
        array $steps,
        array $mitochondrial_processes
    ) {
        $this->name = $name;
        $this->theorem = $theorem;
        $this->steps = $steps;
        $this->mitochondrial_processes = $mitochondrial_processes;
        $this->contributor = $contributor;
        $this->attributes = [];
    }
    
    
    /**
     * Returns name of this pathway.
     * 
     * @return string Name of this pathway
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * Returns conributor of this pathway.
     * 
     * @return string Contributor of this pathway
     */
    public function getContributor(): string {
        return $this->contributor;
    }
    
    /**
     * Returns main theorem of this pathway.
     * 
     * @return Theorem Main theorem of this pathway
     */
    public function getTheorem(): Theorem {
        return $this->theorem;
    }
    
    /**
     * Returns steps of this pathway.
     * 
     * @return array Steps of this pathway
     */
    public function getStepsAsArray(): array {
        return $this->steps;
    }
    
    /**
     * Returns mitochondrial processes involving of this pathway.
     * 
     * @return array Mitochondrial processes involving this pathway
     */
    public function getMitochondrialProcessesAsArray(): array {
        return $this->mitochondrial_processes;
    }

    /**
     * Returns attributes as associative array.
     *
     * @return array Associative array of attributes
     */
    public function getAttributesAsArray(): array {
        return $this->attributes;
    }

    /**
     * Returns an attribute.
     *
     * @param string $name Attribute name
     * @return string Attribute value
     */
    public function getAttribute(string $name): string {
        return array_key_exists($name, $this->attributes) ? $this->attributes[$name] : '';
    }
    
    
    /**
     * Sets name of this pathway.
     * 
     * @param string $name Name of this pathway
     * @return $this This pathway
     */
    public function setName(string $name): Pathway {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Sets contributor of this pathway.
     * 
     * @param string $contributor Contributor of this pathway
     * @return $this This pathway
     */
    public function setContributor(string $contributor): Pathway {
        $this->contributor = $contributor;
        
        return $this;
    }
    
    /**
     * Sets main theorem of this pathway.
     * 
     * @param Theorem $theorem Main theorem of this pathway
     * @return $this This pathway
     */
    public function setTheorem(Theorem $theorem): Pathway {
        $this->theorem = $theorem;
        
        return $this;
    }
    
    /**
     * Adds a mitochondrial process to this pathway.
     * 
     * @param MitochondrialProcess $mitochondrial_process Mitochondrial process to add
     * @return $this This pathway
     */
    public function addMitochondrialProcess(MitochondrialProcess $mitochondrial_process): Pathway {
        $this->mitochondrial_processes[] = $mitochondrial_process;
        
        return $this;
    }

    /**
     * Adds an attribute to this pathway.
     *
     * @param string $name Attribute name
     * @param string $value Attribute value
     * @return $this This pathway
     */
    public function addAttribute(string $name, string $value): Pathway {
        $this->attributes[$name] = $value;

        return $this;
    }
}
