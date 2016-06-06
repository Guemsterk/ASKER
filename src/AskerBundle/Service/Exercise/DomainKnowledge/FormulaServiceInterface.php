<?php
/*
 * This file is part of CLAIRE.
 *
 * CLAIRE is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CLAIRE is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CLAIRE. If not, see <http://www.gnu.org/licenses/>
 */

namespace AskerBundle\Service\Exercise\DomainKnowledge;

use AskerBundle\Model\DomainKnowledge\Formula\Addition;
use AskerBundle\Model\DomainKnowledge\Formula\Cos;
use AskerBundle\Model\DomainKnowledge\Formula\Equation;
use AskerBundle\Model\DomainKnowledge\Formula\Multiplication;
use AskerBundle\Model\DomainKnowledge\Formula\Power;
use AskerBundle\Model\DomainKnowledge\Formula\Sin;
use AskerBundle\Model\DomainKnowledge\Formula\Value;
use AskerBundle\Model\DomainKnowledge\Formula\Variable;
use AskerBundle\Model\Resources\DomainKnowledge\Formula;
use AskerBundle\Model\Resources\DomainKnowledge\Formula\Unknown;
use AskerBundle\Model\Resources\DomainKnowledge\Formula\Variable as ResourceVariable;

/**
 * Interface for the service that manages formulas
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
interface FormulaServiceInterface
{
    /**
     * Check if the syntax of a text equation is correct (brackets, operators, etc.)
     *
     * @param string $equation
     *
     * @return array If no error in the expression
     */
    public function checkTextEquation($equation);

    /**
     * Converts a text expression into an expression tree object
     *
     * @param $expression
     *
     * @return Addition|Cos|Equation|Multiplication|Power|Sin|Value|Variable
     */
    public function textExpressionToExpression($expression);

    /**
     * Resolve an equation for the specified variable
     *
     * @param Equation $equation
     * @param string   $varName
     *
     * @return Equation
     * @throws \Exception
     */
    public function resolveEquation(Equation $equation, $varName);

    /**
     * Instantiate variables from an array of resource variables.
     *
     * @param ResourceVariable[] $resourceVariables The input resource variables
     *
     * @return array An array in wich keys are variable names
     * @throws \AskerBundle\Exception\NotEvaluableException
     */
    public function instantiateVariables(array $resourceVariables);

    /**
     * Resolve a formula and returns values of the variables in an array
     *
     * @param string                                                                            $formula
     * @param \AskerBundle\Model\Resources\DomainKnowledge\Formula\Variable[] $variables
     * @param Unknown                                                                           $unknown
     *
     * @throws \AskerBundle\ApiResourcesBundle\Exception\InvalidKnowledgeException
     * @return array
     */
    public function resolveFormulaResource($formula, $variables, $unknown);

    /**
     * Validate a formula resource
     *
     * @param Formula $content
     *
     * @return bool
     * @throws \AskerBundle\ApiResourcesBundle\Exception\InvalidKnowledgeException
     */
    public function validateFormulaResource(Formula $content);

    /**
     * Get the format (mask) for a value
     *
     * @param $value
     *
     * @return null|string
     */
    public function getValueFormat($value);

    /**
     * Build an array of (unique) formats for an array of values
     *
     * @param $values
     *
     * @return array|null
     */
    public function getValueArrayFormat($values);

    /**
     * Prefix the variable names with the formula name
     *
     * @param array  $variables An array in which keys are variable names and values the values
     * @param string $formulaName
     *
     * @return array
     */
    public function prefixVariableNames($variables, $formulaName);
}
