<?php
/**
 * Theorem.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model
 */
namespace Mitopaths\Model;

/**
 * Theorem.
 *
 * A theorem in the form body => head.
 * 
 * This class follows the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model
 */
class Theorem {
    /** @var Expression\AbstractConjunction $head Head of this theorem. */
    private $head;
    
    /** @var Expression\AbstractConjunction $body Body of this theorem. */
    private $body;
    
    
    /**
     * Constructor.
     *
     * @param Expression\AbstractConjunction $head Head of this theorem
     * @param Expression\AbstractConjunction $body Body of this theorem
     */
    public function __construct(
        Expression\AbstractConjunction $head,
        Expression\AbstractConjunction $body
    ) {
        $this->head = $head;
        $this->body = $body;
    }
    
    
    /**
     * Returns head of this theorem.
     *
     * @return Expression\AbstractConjunction Head of this theorem
     */
    public function getHead(): Expression\AbstractConjunction {
        return $this->head;
    }
    
    /**
     * Returns body of this theorem.
     *
     * @return Expression\AbstractConjunction Body of this theorem
     */
    public function getBody(): Expression\AbstractConjunction {
        return $this->body;
    }
    
    
    /**
     * Sets head of this theorem.
     *
     * @param Expression\AbstractConjunction $head Head of this theorem
     * @return $this This theorem
     */
    public function setHead(Expression\AbstractConjunction $head): Theorem {
        $this->head = $head;
        return $this;
    }
    
    /**
     * Sets body of this theorem.
     *
     * @param Expression\AbstractConjunction $body Body of this theorem
     * @return $this This theorem
     */
    public function setBodt(Expression\AbstractConjunction $body): Theorem {
        $this->body = $body;
        return $this;
    }
}