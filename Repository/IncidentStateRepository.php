<?php

namespace CertUnlp\NgenBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * IncidentStateRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IncidentStateRepository extends EntityRepository
{
    /**
     * @param string $state
     * @return array
     */
    public function findNewStates(string $state): array
    {
        $qb = $this->queryNewStates($state);

        return $qb->getQuery()->getResult();

    }

    /**
     * @param string $state
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    public function queryNewStates(string $state, QueryBuilder $qb = null): QueryBuilder
    {
        $qb2 = $this->queryNewStateSlugs($state);
        $slugs = [];
        foreach ($qb2->getQuery()->getResult() as $item) {
            $slugs[] = $item['slug'];
        }
        $qb = $this->getOrCreateQueryBuilder($qb);

        $qb
            ->where($qb->expr()->in('i.slug', $slugs));

        return $qb;

    }

    /**
     * @param string $state
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    public function queryNewStateSlugs(string $state, QueryBuilder $qb = null): QueryBuilder
    {
        $qb = $this->getOrCreateQueryBuilder($qb);

        $qb
            ->select(' nw.slug')
            ->from('CertUnlpNgenBundle:Incident\State\Edge\StateEdge', 'e')
            ->innerJoin('e.newState', 'nw', 'WITH', 'e.newState = nw.slug')
            ->where('e.oldState = :state')
            ->setParameter('state', $state);

        return $qb;

    }

    /**
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $qb = null): QueryBuilder
    {
        return $qb ?: $this->createQueryBuilder('is');
    }
}
