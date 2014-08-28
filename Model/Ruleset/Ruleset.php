<?php

namespace Mesd\RuleBundle\Model\Ruleset;

use Mesd\RuleBundle\Model\Ruleset\RulesetInterface;
use Mesd\RuleBundle\Model\Context\ContextInterface;
use Mesd\RuleBundle\Model\Action\AbstractServiceAction;
use Mesd\RuleBundle\Model\Attribute\AbstractServiceAttribute;
use Mesd\RuleBundle\Model\Rule\RuleNodeInterface;
use Mesd\RuleBundle\Model\Context\ContextCollectionInterface;

class Ruleset implements RulesetInterface
{
    ///////////////
    // VARIABLES //
    ///////////////

    /**
     * The list of associated contexts
     * @var ContextCollectionInterface
     */
    private $contextCollection;

    /**
     * The list of root rules that are excuted initially
     * @var array
     */
    private $rootRules;

    /**
     * The name of the ruleset
     * @var string
     */
    private $name;

    /**
     * Array of serivce attributes
     * @var array
     */
    private $serviceAttributes;

    /**
     * Array of service actions
     * @var array
     */
    private $serviceActions;

    //////////////////
    // BASE METHODS //
    //////////////////


    /**
     * Constructor
     *
     * @param string $name The name of the ruleset
     */
    public function __construct($name, ContextCollectionInterface $contextCollection) {
        //Set stuff
        $this->name = $name;
        $this->contextCollection = $contextCollection;

        //Init stuff
        $this->rootRules = array();
        $this->serviceAttributes = array();
        $this->serviceActions = array();
    }


    /////////////////////////
    // IMPLEMENTED METHODS //
    /////////////////////////


    /**
     * Evaluate the enter rule set with the context objects set
     *
     * @param  array   The array of values to set the contexts by
     * 
     * @return boolean The result of the evaluation
     */
    public function evaluate($contextValues = []) {
        $return = true;

        //Set the context values
        $this->contextCollection->setValues($contextValues);

        //Evaluate each node
        foreach($this->rootRules as $rule) {
            $eval = $rule->evaluate();
            $return = $return && $eval;
        }
        //Return the final boolean
        return $return;
    }


    /**
     * Adds a rule node to the list of root rule nodes that are executed initially upon evaluation
     *
     * @param RuleNodeInterface $ruleNode A rule node
     */
    public function addRootRuleNode(RuleNodeInterface $ruleNode) {
        $this->rootRules[] = $ruleNode;
    }


    /**
     * Adds a service attribute to the ruleset
     *
     * @param AbstractServiceAttribute $attribute The service attribute to add
     */
    public function addServiceAttribute(AbstractServiceAttribute $attribute) {
        $this->serviceAttributes[$attribute->getName()] = $attribute;
    }


    /**
     * Gets the list of service attributes associated with the ruleset
     *
     * @return array Array of AbstractServiceAttribute
     */
    public function getServiceAttributes() {
        return $this->serviceAttributes;
    }


    /**
     * Adds a service action to the ruleset
     *
     * @param AbstractServiceAction $action The service action to add
     */
    public function addServiceAction(AbstractServiceAction $action) {
        $this->serviceActions[$action->getName()] = $action;
    }


    /**
     * Gets the list of service actions associated with the ruleset
     *
     * @return array Array of AbstractServiceAction
     */
    public function getServiceActions() {
        return $this->serviceActions;
    }


    /**
     * Returns a list of all the attributes this ruleset knows of
     *
     * @return array All Attributes associated with the ruleset
     */
    public function getAllAttributes() {
        $attributes = array();

        //Add the service attributes
        $attributes['Ruleset'] = $this->getServiceAttributes();

        //Add each contexts attributes
        foreach($this->contexts as $context) {
            $attributes[$context->getName()] = $context->getAttributes();
        }

        //Return
        return $attributes;
    }


    /**
     * Returns a list of all the actions this ruleset knows of
     *
     * @return array All Actions associated with the ruleset
     */
    public function getAllActions() {
        $actions = array();

        //Add the service attributes
        $actions['Ruleset'] = $this->getServiceActions();

        //Add each contexts actions
        foreach($this->contexts as $context) {
            $actions[$context->getName()] = $context->getActions();
        }

        //Return
        return $actions;
    }


    /**
     * Get the context collection currently associated with the ruleset
     *
     * @return ContextCollectionInterface The context collection
     */
    public function getContextCollection() {
        return $this->contextCollection;
    }


    /**
     * Get the name of the ruleset
     *
     * @return string The name of the ruleset
     */
    public function getName() {
        return $this->name;
    }


    /////////////
    // METHODS //
    /////////////


    /**
     * Return the array of root rule nodes for this ruleset
     *
     * @return array The list of root rule nodes
     */
    public function getRootRuleNodes() {
        return $this->rootRules;
    }


    /**
     * Checks that root rules exist for the ruleset
     *
     * @return boolean Whether root rules exist
     */
    public function checkThatRootRulesExist() {
        if (0 < count($this->rootRules)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Check if there are cycles in the rule structure
     *
     * @return boolean Whether cycles exist or not
     */
    public function checkIfCyclesExist() {
        $return = false;
        foreach($this->rootRules as $node) {
            $return = $return || $this->visitNode($node, array());
        }
        return $return;
    }


    /////////////////////
    // PRIVATE METHODS //
    /////////////////////


    /**
     * Check if a node has already been visited in a given chain
     *
     * @param  RuleNodeInterface $node    The node to check
     * @param  array             $visited The list of visited nodes
     *
     * @return boolean                    True if the node has been visited, false else wise
     */
    private function visitNode(RuleNodeInterface $node, $visited) {
        //Check if the current node is in the visited array
        if (in_array($node->getName(), $visited)) {
            return true;
        } else {
            //Add to the visited array
            $visited[] = $node->getName();

            //Call recursively foreach child
            $return = false;
            foreach($node->getThenRules() as $then) {
                $return = $return || $this->visitNode($then, $visited);
            }
            foreach($node->getElseRules() as $else) {
                $return = $return || $this->visitNode($else, $visited);
            }

            return $return;
        }
    }
}