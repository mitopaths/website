<?php
/**
 * Scanner.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model\Expression\Parser
 */
namespace Mitopaths\Model\Expression\Parser;

/**
 * Scanner.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model\Expression\Parser
 */
class Scanner {
    /** @var array $symbols Array of strings recognized as symbols. */
    private $symbols = [',', '(', ')', '{', '}', ':'];
    
    /** @var array $spaces Array of string recognized as spaces. */
    private $spaces = [" ", "\n", "\r", "\t"];
    
    
    /**
     * Scans an input string.
     *
     * @param string $input Input string
     * @param int $start Index of first character
     * @retun array Array of tokens
     */
    public function scan(&$input, $start = 0) {
        if ($start >= strlen($input)) {
            return [];
        }
        
        $first = $input[$start];
        
        // First character is a space
        if (in_array($first, $this->spaces)) {
            return $this->scan($input, $start + 1);
        }
        
        // First character is a symbol
        if (in_array($first, $this->symbols)) {
            $symbol = new Symbol($first);
            $tokens = $this->scan($input, $start + 1);
            array_unshift($tokens, $symbol);
            
            return $tokens;
        }
        
        // First character is a double quote
        if ($first === '"') {
            $identifier = $this->scanQuotedIdentifier($input, $start + 1);
            $offset = strlen($identifier->getIdentifier()) + 2;
            $tokens = $this->scan($input, $start + $offset);
            array_unshift($tokens, $identifier);
            
            return $tokens;
        }
        
        // None of the above: treat input as an identifier
        $identifier = $this->scanIdentifier($input, $start);
        $offset = strlen($identifier->getIdentifier());
        $tokens = $this->scan($input, $start + $offset);
        array_unshift($tokens, $identifier);
        
        return $tokens;
    }
    
    
    /**
     * Scans an identifer.
     *
     * @param string $input Input string
     * @param int $start Index of first character
     * @retun Identifier Identifier
     */
    private function scanIdentifier(&$input, $start) {
        for (
            $i = $start;
            $i < strlen($input) && !in_array($input[$i], $this->spaces) && !in_array($input[$i], $this->symbols);
            ++$i
        ) {
        }
        
        return new Identifier(substr($input, $start, $i - $start));
    }
    
    
    /**
     * Scans a quoted identifier.
     *
     * @param string $input Input string
     * @param int $start Index of first character
     * @retun Identifier Identifier
     */
    private function scanQuotedIdentifier(&$input, $start) {
        $position = strpos($input, '"', $start);
        
        return new Identifier(substr($input, $start, $position - $start));
    }
}