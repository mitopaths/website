<?php
/**
 * Visitor interface for an expression.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Model\Expression
 */
namespace Mitopaths\Model\Expression;

/**
 * Visitor interface for an expression.
 *
 * This class follows the Visitor.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Model\Expression
 */
interface VisitorInterface {
    /**
     * Visits an expression.
     *
     * @param AbstractConjunction $subject Expression to visit
     * @return mixed Result of the visit
     */
    public function visit(AbstractConjunction $subject);
}