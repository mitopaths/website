<?php
/**
 * Parser.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model\Expression\Parser
 */
namespace Mitopaths\Model\Expression\Parser;

/**
 * Parser.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model\Expression\Parser
 */
class Parser {
    /** @var \Mitopaths\DataMapper\AbstractMolecule $molecule_data_mapper Data mapper to read molecules. */
    private $molecule_data_mapper;
    
    
    /**
     * Constructor.
     *
     * @param \Mitopaths\DataMapper\AbstractMolecule $molecule_data_mapper Data mapper to read molecule
     */
    public function __construct($molecule_data_mapper) {
        $this->molecule_data_mapper = $molecule_data_mapper;
    }
    
    
    /**
     * Parses an input string.
     *
     * @param string $input Input string
     * @return \Mitopaths\Model\Expression\AbstractConjunction Expression
     */
    public function parse(string $input): \Mitopaths\Model\Expression\AbstractConjunction {
        $scanner = new Scanner();
        $tokens = $scanner->scan($input);
        
        return $this->parseConjunction($tokens);
    }
    
    
    /**
     * Parses a conjunction.
     *
     * @param array $tokens List of token
     * @param int $start Position of first token in the list
     * @return \Mitopaths\Model\Expression\AbstractConjunction Expression
     * @throw SyntaxError In case of syntax error
     */
    private function parseConjunction(&$tokens, &$start = 0) {
        // Empty list: syntax error
        if ($start >= count($tokens)) {
            throw new SyntaxError($tokens, $start, ['{', '(', 'name']);
        }
        
        $first = $tokens[$start];
        
        // First token is {
        if ($first instanceof Symbol && $first->getSymbol() === "{") {
            ++$start;
            $interaction = $this->parseInteraction($tokens, $start);
            $interaction_list = $this->parseInteractionList($tokens, $start);
            array_unshift($interaction_list, $interaction);
            
            return new \Mitopaths\Model\Expression\Conjunction($interaction_list);
        }
        
        // First token is ( or an identifier
        elseif (($first instanceof Symbol && $first->getSymbol() === "(") || $first instanceof Identifier) {
            return $this->parseInteraction($tokens, $start);
        }
        
        // Else: syntax error
        throw new SyntaxError($tokens, $start, ['{', '(', 'name']);
    }
    
    /**
     * Parses an interaction.
     *
     * @param array $tokens List of token
     * @param int $start Position of first token in the list
     * @return \Mitopaths\Model\Expression\AbstractInteraction Expression
     * @throw SyntaxError In case of syntax error
     */
    private function parseInteraction(&$tokens, &$start) {
        // Empty list: syntax error
        if ($start >= count($tokens)) {
            throw new SyntaxError($tokens, $start, ['(', 'name']);
        }
        
        $first = $tokens[$start];
        
        // First token is "("
        if ($first instanceof Symbol && $first->getSymbol() === "(") {
            ++$start;
            $interaction = $this->parseInteraction($tokens, $start);
            $interaction_list = $this->parseInteractionList($tokens, $start);
            array_unshift($interaction_list, $interaction);
            
            $attributes = $this->parseAttributes($tokens, $start);
            $position = \Mitopaths\Model\Expression\AbstractInteraction::NA;
            if (array_key_exists('position', $attributes)) {
                $position = $attributes['position'];
                unset($attributes['position']);
            }
            
            return new \Mitopaths\Model\Expression\Interaction($interaction_list, $position, $attributes);
        }
        
        // First token is an identifier
        elseif ($first instanceof Identifier) {
            ++$start;
            $molecule = $this->molecule_data_mapper->read($first->getIdentifier());
            $attributes = $this->parseAttributes($tokens, $start);
            $position = \Mitopaths\Model\Expression\AbstractInteraction::NA;
            if (array_key_exists('position', $attributes)) {
                $position = $attributes['position'];
                unset($attributes['position']);
            }
            
            return new \Mitopaths\Model\Expression\AbstractMoleculeDecorator($molecule, $position, $attributes);
        }
        
        // Else: syntax error
        throw new SyntaxError($tokens, $start, ['(', 'name']);
    }
    
    /**
     * Parses a list of components.
     *
     * @param array $tokens List of token
     * @param int $start Position of first token in the list
     * @return array List of components
     * @throw SyntaxError In case of syntax error
     */
    private function parseInteractionList(&$tokens, &$start) {
        // Empty list: syntax error
        if ($start >= count($tokens)) {
            throw new SyntaxError($tokens, $start, ['}', ')', ',']);
        }
        
        $first = $tokens[$start];
        $list = [];
        
        // First token is "}" or ")"
        if ($first instanceof Symbol && ($first->getSymbol() === "}" || $first->getSymbol() === ")")) {
            ++$start;
            
            return $list;
        }
        
        // First token is ","
        if ($first instanceof Symbol && $first->getSymbol() === ",") {
            ++$start;
            $interaction = $this->parseInteraction($tokens, $start);
            $list = $this->parseInteractionList($tokens, $start);
            array_unshift($list, $interaction);
            
            return $list;
        }
        
        // Else: syntax error
        throw new SyntaxError($tokens, $start, ['}', ')', ',']);
    }
    
    /**
     * Parses a list of attributes.
     *
     * @param array $tokens List of token
     * @param int $start Position of first token in the list
     * @return array Associative array of attributes
     * @throw SyntaxError In case of syntax error
     */
    private function parseAttributes(&$tokens, &$start) {
        $attributes = [];
        
        // End of tokens
        if ($start >= count($tokens)) {
            return $attributes;
        }
        
        $first = $tokens[$start];
        
        // First token is "}", ")", ","
        if ($first instanceof Symbol && ($first->getSymbol() === "}" || $first->getSymbol() === ")" || $first->getSymbol() === ",")) {
            return $attributes;
        }
        
        // First token is an identifier
        if ($first instanceof Identifier) {
            $key = $first;
            ++$start;
            
            $next = $tokens[$start];
            ++$start;
            if (!($next instanceof Symbol) || $next->getSymbol() !== ":") {
                throw new SyntaxError($tokens, $start, [':']);
            }
            
            $identifier = $tokens[$start];
            ++$start;
            if (!($identifier instanceof Identifier)) {
                throw new SyntaxError($tokens, $start, ['identifier']);
            }
            
            $attributes = $this->parseAttributes($tokens, $start);
            $attributes[$key->getIdentifier()] = $identifier->getIdentifier();
            
            return $attributes;
        }
        
        // Else: syntax error
        throw new SyntaxError($tokens, $start, ['}', ')', ',', 'identifier', 'end of input']);
    }
}