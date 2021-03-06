<?php
/**
 * Protein.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model
 */
namespace Mitopaths\Model;

/**
 * Protein.
 *
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model
 */
class Protein extends AbstractMolecule {
    /**
     * Constructor.
     *
     * @param string $name Name of this molecule
     * @param string $description Description of this molecule
     * @param array Associative array of attributes
     */
    function __construct(string $name, $description, array $attributes = []) {
        parent::__construct($name, $description, $attributes);
    }
}