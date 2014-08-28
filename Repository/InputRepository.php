<?php

namespace Mesd\RuleBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * InputRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InputRepository extends EntityRepository
{
    /**
     * Load all
     *
     * @return array All of the inputs saved in the database
     */
    public function loadAll() {
        $qb = $this->createQueryBuilder('input');
        $qb->select('input');
        return $qb->getQuery()->getResult();
    }
}
