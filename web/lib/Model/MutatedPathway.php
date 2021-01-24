<?php
/**
 * Mutated pathway.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model
 */
namespace Mitopaths\Model;

/**
 * Mutated pathway.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model
 */
class MutatedPathway extends Pathway {
    /** @var string $original_pathway Original pathway. */
    private $original_pathway;
    
    
    /**
     * Constructor.
     *
     * @param string $name Name of the mutated pathway
     * @param string $contributor Name of the contributor
     * @param Theorem $theorem Main theorem
     * @param array $steps Array of steps
     * @param array $mitochondrial_processes Array of mitochondrial processes
     * @param Pathway $original_pathway Original pathway
     */
    public function __construct(
        string $name,
        string $contributor,
        Theorem $theorem,
        array $steps,
        array $mitochondrial_processes,
        Pathway $original_pathway
    ) {
        parent::__construct($name, $contributor, $theorem, $steps, $mitochondrial_processes);
        $this->original_pathway = $original_pathway;
    }
    
    
    /**
     * Returns original pathway.
     *
     * @return Pathway Original pathway
     */
    public function getOriginalPathway(): Pathway {
        return $this->original_pathway;
    }
    
    
    /**
     * Sets original pathway.
     *
     * @param Pathway $original_pathway Original pathway
     * @return $this This mutated pathway
     */
    public function setOriginalPathway(Pathway $original_pathway): MutatedPathway {
        $this->original_pathway = $original_pathway;
        
        return $this;
    }
}