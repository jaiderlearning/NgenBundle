<?php

namespace CertUnlp\NgenBundle\Repository;

use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use Doctrine\ORM\EntityRepository;

/**
 * IncidentDecisionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IncidentDecisionRepository extends EntityRepository
{
    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return IncidentDecision[]|[]
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $get_undefined = false;
        $criteria['isActive'] = true;
        $criteria['network'] = is_object($criteria['network']) ? $criteria['network']->getId() : $criteria['network'];
        if (!$criteria['network']) {
            unset($criteria['network']);
        }
        if (isset($criteria['get_undefined'])) {
            $get_undefined = $criteria['get_undefined'];
            unset($criteria['get_undefined']);
        }
        if ($get_undefined) {
            $decision = null;
            if (isset($criteria['type'], $criteria['feed'])) {
                $decision = parent::findOneBy(array('feed' => $criteria['feed'], 'type' => $criteria['type'], 'network' => $criteria['network'] ?? null, 'isActive' => true), $orderBy);
            }
            if (!$decision && isset($criteria['type']) && !isset($criteria['feed'])) {
                $decision = parent::findOneBy(array('feed' => 'undefined', 'type' => $criteria['type'], 'network' => $criteria['network'] ?? null, 'isActive' => true), $orderBy);
            }
            if (!$decision && !isset($criteria['type']) && isset($criteria['feed'])) {
                $decision = parent::findOneBy(array('feed' => $criteria['feed'], 'type' => 'undefined', 'network' => $criteria['network'] ?? null, 'isActive' => true), $orderBy);
            }
            if (!$decision && isset($criteria['network'])) {
                $decision = parent::findOneBy(array('feed' => 'undefined', 'type' => 'undefined', 'network' => $criteria['network'], 'isActive' => true), $orderBy);
            }
            if (!$decision) {
                $decision = parent::findOneBy(array('feed' => 'undefined', 'type' => 'undefined', 'network' => null, 'isActive' => true), $orderBy);
            }
            return $decision;
        }

        return parent::findOneBy($criteria, $orderBy);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array|object|null
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $get_undefined = false;
        $criteria['isActive'] = true;
        if (isset($criteria['get_undefined'])) {
            $get_undefined = $criteria['get_undefined'];
            unset($criteria['get_undefined']);
        }
        if ($get_undefined) {
            $decision = null;
            if (isset($criteria['type'], $criteria['feed'])) {
                $decision = parent::findBy(array('feed' => $criteria['feed'], 'type' => $criteria['type'], 'isActive' => true), $orderBy, $limit, $offset);
            }
            if (!$decision && isset($criteria['type']) && !isset($criteria['feed'])) {
                $decision = parent::findBy(array('feed' => 'undefined', 'type' => $criteria['type'], 'isActive' => true), $orderBy, $limit, $offset);
            }
            if (!$decision && !isset($criteria['type']) && isset($criteria['feed'])) {
                $decision = parent::findBy(array('feed' => $criteria['feed'], 'type' => 'undefined', 'isActive' => true), $orderBy, $limit, $offset);
            }
            if (!$decision && isset($criteria['network'])) {
                $decision = parent::findBy(array('feed' => 'undefined', 'type' => 'undefined', 'isActive' => true), $orderBy, $limit, $offset);
            }
            $decision = array_merge($decision, parent::findBy(array('feed' => 'undefined', 'type' => 'undefined', 'isActive' => true), $orderBy, $limit, $offset));
            return $decision;
        }
        return parent::findBy($criteria, $orderBy, $limit, $offset); // TODO: Change the autogenerated stub
    }
}
