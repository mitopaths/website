<?php
/**
 * Generic interaction.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model\Expression
 */
namespace Mitopaths\Model\Expression;

/**
 * Generic interaction.
 *
 * This class follows the Visiitor and the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model\Expression
 */
abstract class AbstractInteraction extends AbstractConjunction {
    const  NA = 0x0;
    const   M = 0x1;
    const  IM = 0x2;
    const IMS = 0x4;
    const  OM = 0x8;
    const ONS = 0x10;
    const ANY = 0x1F;
    
    
    /** @var int $position Position code withing the mitochondrion. */
    private $position;
    
    /** @var array $attributes Array of additional attributes. */
    private $attributes;
    
    
    /**
     * Returns true if this interaction has given attribute.
     *
     * @param string $name Name of the attribute
     * @return bool True if and only if this interaction has given attribute
     */
    public function hasAttribute(string $name): bool {
        return array_key_exists($name, $this->attributes);
    }
    
    
    /**
     * Returns position code of this interaction.
     *
     * @return int Position code of this interaction within the mitochondrion
     */
    public function getPosition(): int {
        return $this->position;
    }
    
    /**
     * Returns attributes of this interaction.
     *
     * @return array Associative array of attributes of this interaction
     */
    public function getAttributesAsArray(): array {
        return $this->attributes;
    }
    
    /**
     * Returns attribute of this interaction with given name.
     *
     * @param string $name Name of the attribute
     * @return string Value of given attribute
     * @throw \Exception If this interaction does not have given attribute
     */
    public function getAttribute(string $name): string {
        if (!$this->hasAttribute($name)) {
            throw new \Exception("Trying to access non-existing attribute \"$name\".");
        }
        
        return $this->attributes[$name];
    }
    
    
    /**
     * Sets position code of this interaction.
     *
     * @param int $position Position code of this interaction within the mitochondrion
     * @return $this This interaction
     */
    public function setPosition(int $position): AbstractInteraction {
        $this->position = $position & self::ANY;
        return $this;
    }
    
    /**
     * Adds a position code to this interaction.
     *
     * @param int $position Position code to add
     * @return $this This interaction
     */
    public function addPosition(int $position): AbstractInteraction {
        $this->position = $this->position | ($position & self::ANY);
        
        return $this;
    }
    
    /**
     * Removes a position code of this interaction.
     *
     * @param int $position Position code to remove
     * @return $this This interaction
     */
    public function removePosition(int $position): AbstractInteraction {
        $this->position = $this->position & ~($position & self::ANY);
        
        return $this;
    }
    
    /**
     * Sets additional attributes of this interaction.
     *
     * @param array $attributes Associative array of additional attributes
     * @return $this This interaction
     */
    public function setAttributes(array $attributes): AbstractInteraction {
        $this->attributes = $attributes;
        
        return $this;
    }
    
    /**
     * Adds an attribute to this interaction.
     *
     * @param string $name Name of the attribute to add
     * @param string $value Value of the attribute to add
     * @return $this This interaction
     */
    public function addAttribute(string $name, string $value): AbstractInteraction {
        $this->attributes[$name] = $value;
        
        return $this;
    }
    
    /**
     * Removes an attribute from this interaction.
     *
     * Nothing happens if this interaction does not have given attribute.
     *
     * @param string $name Name of the attribute to remove
     * @return $this This interaction
     */
    public function removeAttribute(string $name): AbstractInteraction {
        if ($this->hasAttribute($name)) {
            unset($this->attributes[$name]);
        }
        
        return $this;
    }
}