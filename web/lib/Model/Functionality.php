<?php
/**
 * Functionality.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model
 */
namespace Mitopaths\Model;

/**
 * Functionality.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model
 */
class Functionality {
    /** @var string $name Name of this functionality. */
    private $name;
    
    /** @var string $description Description of this functionality. */
    private $description;
    
    
    /**
     * Constructor.
     *
     * @param string $name Name of this functionality
     * @param string $description Description of this functionality
     */
    public function __construct(string $name, string $description) {
        $this->name = $name;
        $this->description = $description;
    }
    
    
    /**
     * Returns name of this functionality.
     *
     * @return string Name of this functionality
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * Returns description of this functionality.
     *
     * @return string Description of this functionality
     */
    public function getDescription(): string {
        return $this->description;
    }
    
    
    /**
     * Sets name of this functionality.
     *
     * @param string $name Name of this functionality
     * @return $this This functionality
     */
    public function setName(string $name): Functionality {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Sets description of this functionality.
     *
     * @param string $description Description of this functionality
     * @return $this This functionality
     */
    public function setDescription(string $description): Functionality {
        $this->description = $description;
        return $this;
    }
}