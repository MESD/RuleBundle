<?php

namespace Mesd\RuleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Mesd\RuleBundle\Entity\ActionEntity;

/**
 * ActionRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActionRepository extends EntityRepository
{
    /**
     * Get the requested action entity for the given context.
     *
     * @param string $contextName The name of the parent context
     * @param string $actionName  The name of the action
     *
     * @return ActionEntity The matching action entity
     */
    public function getContextAction($contextName, $actionName)
    {
        $qb = $this->createQueryBuilder('action')
            ->join('action.context', 'context')
            ->andWhere('action.name = :name')
            ->andWhere('context.name = :contextName')
            ->setParameter('name', $actionName)
            ->setParameter('contextName', $contextName)
            ->setMaxResults(1);
        $res = $qb->getQuery()->getResult();
        if (0 < count($res)) {
            return $res[0];
        } else {
            return;
        }
    }

    /**
     * Get the requested action entity for the given service.
     *
     * @param string $serviceName The name of the parent service
     * @param string $actionName  The name of the action
     *
     * @return ActionEntity The matching action entity
     */
    public function getServiceAction($serviceName, $actionName)
    {
        $qb = $this->createQueryBuilder('action')
            ->join('action.service', 'service')
            ->andWhere('action.name = :name')
            ->andWhere('service.name = :serviceName')
            ->setParameter('name', $actionName)
            ->setParameter('serviceName', $serviceName)
            ->setMaxResults(1);
        $res = $qb->getQuery()->getResult();
        if (0 < count($res)) {
            return $res[0];
        } else {
            return;
        }
    }
}
