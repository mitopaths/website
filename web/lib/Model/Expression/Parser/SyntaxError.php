<?php
/**
 * Syntax error.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model\Expression\Parser
 */
namespace Mitopaths\Model\Expression\Parser;

/**
 * Syntax error.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model\Expression\Parser
 */
class SyntaxError extends \Exception {
    /**
     * Constructor.
     *
     * @param array $tokens List of tokens
     * @param int $start Index of first token
     * @param array $expected Array of expected strings
     */
    public function __construct($tokens, $start, $expected) {
        $found = [];
        for ($i = $start; $i < count($tokens); ++$i) {
            $token = $tokens[$i];
            
            if ($token instanceof Symbol) {
                $found[] = $token->getSymbol();
            }
            
            elseif ($token instanceof Identifier) {
                $found[] = $token->getIdentifier();
            }
        }
        
        
        $this->message = "[SYNTAX ERROR] "
            . "Expecting: \"" . implode("\" or \"", $expected) . "\", "
            . "but found: \"" . implode(" ", $found) . "\".";
    }
}