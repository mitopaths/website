<?php
/**
 * Mutated protein.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model
 */
namespace Mitopaths\Model;

/**
 * Mutated protein.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model
 */
class MutatedProtein extends AbstractMolecule {
    /** @var Protein $original_protein Original protein. */
    private $original_protein;
    
    /** @var array $lost_function Array of lost functionalities. */
    private $lost_functions;
    
    /** @var array $gained_function Array of gained functionalities. */
    private $gained_functions;
    
    /** @var array $pathologies Array of pathologies associated to this mutation. */
    private $pathologies;
    
    
    /**
     * Constructor.
     *
     * @param string $name Name of this mutated protein
     * @param string $description Description of this mutated protein
     * @param Protein $original_protein Original protein
     * @param array $attributes Associative array of additional attributes
     * @param array $lost_functions Array of lost functionalities
     * @param array $gained_functions Array of gained functionalities
     * @param array $pathologies Array of pathologies
     */
    public function __construct(
        string $name,
        $description,
        Protein $original_protein,
        array $attributes = [],
        array $lost_functions = [],
        array $gained_functions = [],
        array $pathologies = []
    ) {
        parent::__construct($name, $description, $attributes);
        $this->original_protein = $original_protein;
        $this->lost_functions = $lost_functions;
        $this->gained_functions = $gained_functions;
        $this->pathologies = $pathologies;
    }
    
    
    /**
     * Returns original protein.
     *
     * @return Protein Original protein
     */
    public function getOriginalProtein(): Protein {
        return $this->original_protein;
    }
    
    /**
     * Returns lost functionalities.
     *
     * @return array Lost functionalities
     */
    public function getLostFunctionsAsArray(): array {
        return $this->lost_functions;
    }
    
    /**
     * Returns gained functionalities.
     *
     * @return array Gained functionalities
     */
    public function getGainedFunctionsAsArray(): array {
        return $this->gained_functions;
    }
    
    /**
     * Returns pathologies.
     *
     * @return array Pathologies associated to this mutation
     */
    public function getPathologiesAsArray(): array {
        return $this->pathologies;
    }
    
    
    /**
     * Sets original protein.
     *
     * @param Protein $original_protein Original protein
     * @return $this This mutated protein
     */
    public function setOriginalProtein(Protein $original_protein): MutatedProtein {
        $this->original_protein = $original_protein;
        
        return $this;
    }
}