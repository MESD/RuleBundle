<?php

namespace Mesd\RuleBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * RulesetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RulesetRepository extends EntityRepository
{
    /**
     * Load all
     *
     * @return array All of the rulesets saved in the database
     */
    public function loadAll() {
        $qb = $this->createQueryBuilder('ruleset');
        $qb->select('ruleset');
        return $qb->getQuery()->getResult();
    }
}
