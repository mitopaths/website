<?php
/**
 * Generic conjunction.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model\Expression
 */
namespace Mitopaths\Model\Expression;

/**
 * Generic conjunction.
 *
 * This class follows the Visitor and the Model View Controller Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model\Expression
 */
abstract class AbstractConjunction {
    /**
     * Accepts a visitor.
     *
     * @param VisitorInterface $visitor Visitor to accept
     * @return mixed Result of the visit
     */
    abstract public function accept(VisitorInterface $visitor);
}