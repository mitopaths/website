<?php
/**
 * Molecule.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model
 */
namespace Mitopaths\Model;

/**
 * Molecule.
 *
 * A general molecule, including actual molecules, proteins, and so on.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model
 */
abstract class AbstractMolecule {
    /** @var string $name Name of this molecule. */
    private $name;
    
    /** @var string $description Description of this molecule. */
    private $description;
    
    /** @var array $attributes Associative array of attributes. */
    private $attributes;
    
    
    /**
     * Constructor.
     *
     * @param string $name Name of this molecule
     * @param string $description Description of this molecule
     * @param array Associative array of attributes
     */
    protected function __construct(string $name, $description, array $attributes = []) {
        $this->name = $name;
        $this->description = $description;
        $this->attributes = $attributes;
    }
    
    
    /**
     * Returns true if this molecule has given attribute.
     *
     * @param string $name Name of the attribute
     * @return bool True if and only if this molecule has given attribute
     */
    public function hasAttribute(string $name): bool {
        return array_key_exists($name, $this->attributes);
    }
    
    /**
     * Returns true if given molecule is equal to this.
     *
     * @param AbstractMolecule $that Molecule to compare
     * @return bool True if and only if the molecules are the same
     */
    public function isEqual(AbstractMolecule $that) {
        return $this->name === $that->name;
    }
    
    
    /**
     * Returns name of this molecule.
     *
     * @return string Name of this molecule
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * Returns description of this molecule.
     *
     * @return string Description of this molecule
     */
    public function getDescription() {
        return $this->description;
    }
    
    /**
     * Returns attributes of this molecule.
     *
     * @return array Associative array of attributes of this molecule
     */
    public function getAttributesAsArray(): array {
        return $this->attributes;
    }
    
    /**
     * Returns value of an attribute of this molecule.
     *
     * @param string $name Name of an attribute
     * @return string Value of the attribute
     * @throw \Exception If this molecule does not have given attribute
     */
    public function getAttribute(string $name): string {
        if (!$this->hasAttribute($name)) {
            throw new \Exception("Trying to accessing non-exsisting attribute \"$name\".");
        }
        
        return $this->attributes[$name];
    }
    
    
    /**
     * Sets name of this molecule.
     *
     * @param string $name Name of this molecule
     * @return $this This molecule
     */
    public function setName(string $name): AbstractMolecule {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Sets description of this molecule.
     *
     * @param string $description Description of this molecule
     * @return $this This molecule
     */
    public function setDescription($description): AbstractMolecule {
        $this->description = $description;
        return $this;
    }
    
    /**
     * Adds an attribute to this molecule.
     *
     * If an attribute with the same name exists, it is overwritten.
     *
     * @param string $name Name of the attribute
     * @param string $value Value of the attribute
     * @return $this This molecule
     */
    public function addAttribute(string $name, string $value): AbstractMolecule {
        $this->attributes[$name] = $value;
        return $this;
    }
    
    /**
     * Removes an attribute from this molecule.
     *
     * If this molecule does not have given attributes, nothing happens.
     *
     * @param string $name Name of the attribute to remove
     * @return $this This molecule
     */
    public function removeAttribute(string $name): AbstractMolecule {
        if ($this->hasAttribute($name)) {
            unset($this->attributes[$name]);
        }
        
        return $this;
    }
}