<?php
/**
 * Mitochondrial process.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model
 */
namespace Mitopaths\Model;

/**
 * Mitochondrial process.
 *
 * Also known as "category".
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model
 */
class MitochondrialProcess {
    /** @var string $name Name of this mitochondrial process. */
    private $name;
    
    /** @var string $description Description of this mitochondrial process. */
    private $description;
    
    
    /**
     * Constructor.
     *
     * @param string $name Name of this mitochondrial process
     * @param string $description Description of this mitochondrial process
     */
    public function __construct(string $name, string $description) {
        $this->name = $name;
        $this->description = $description;
    }
    
    
    /**
     * Returns name of this mitochondrial process.
     *
     * @return string Name of this mitochondrial process
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * Returns description of this mitochondrial process.
     *
     * @return string Description of this mitochondrial process
     */
    public function getDescription(): string {
        return $this->description;
    }
    
    
    /**
     * Sets name of this mitochondrial process.
     *
     * @param string $name Name of this mitochondrial process
     * @return $this This mitochondrial process
     */
    public function setName(string $name): AbstractMolecule {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Sets description of this mitochondrial process.
     *
     * @param string $description Description of this mitochondrial process
     * @return $this This mitochondrial process
     */
    public function setDescription(string $description): AbstractMolecule {
        $this->description = $description;
        return $this;
    }
}