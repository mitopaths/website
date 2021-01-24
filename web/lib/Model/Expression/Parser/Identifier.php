<?php
/**
 * Identifier.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model\Expression\Parser
 */
namespace Mitopaths\Model\Expression\Parser;

/**
 * Identifier.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model\Expression\Parser
 */
class Identifier extends Token {
    /** @var string $identifier Identifier. */
    private $identifier;
    
    
    /**
     * Constructor.
     *
     * @param string $identifier Identifiier
     */
    public function __construct(string $identifier) {
        $this->identifier = $identifier;
    }
    
    
    /**
     * Returns identifier.
     *
     * @return string Identifier
     */
    public function getIdentifier(): string {
        return $this->identifier;
    }
}