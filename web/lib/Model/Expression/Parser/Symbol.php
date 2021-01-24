<?php
/**
 * Symbol.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model\Expression\Parser
 */
namespace Mitopaths\Model\Expression\Parser;

/**
 * Symbol.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model\Expression\Parser
 */
class Symbol extends Token {
    /** @var string $symbol Symbol. */
    private $symbol;
    
    /**
     * Constructor.
     *
     * @param string $symbol Symbol
     */
    public function __construct($symbol) {
        $this->symbol = $symbol;
    }
    
    
    /**
     * Returns symbol.
     *
     * @return string Symbol
     */
    public function getSymbol() {
        return $this->symbol;
    }
}