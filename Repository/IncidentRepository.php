<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * IncidentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IncidentRepository extends EntityRepository
{

    function findByHostDateType($parameters)
    {
        $query = $this->createQueryBuilder('i')
            ->where('i.type = :type')
            ->andWhere('i.hostAddress = :hostAddress')
            ->andWhere('i.date = :date')
//                ->andWhere('i.isClosed = :closed')
            ->setParameter('type', $parameters['type'])
            ->setParameter('hostAddress', $parameters['hostAddress'])
//                ->setParameter('closed', FALSE)
            ->setParameter('date', $parameters['date']);

        return $query->getQuery()->getOneOrNullResult();
    }

    public function findByUnique($parameters)
    {
        $query = $this->createQueryBuilder('i')
            ->where('i.type = :type')
            ->andWhere('i.hostAddress = :hostAddress')
            ->andWhere('i.isClosed = :closed')
            ->setParameter('type', $parameters['type'])
            ->setParameter('hostAddress', $parameters['hostAddress'])
            ->setParameter('closed', FALSE);

        $incident = $query->getQuery()->getOneOrNullResult();
        if ($incident) {
            $incident->setLastTimeDetected(new \DateTime('now'));
        }
        return [];
    }

    public function findRenotificables($parameters = [])
    {
        $query = $this->createQueryBuilder('i')
//                ->select('count(i)')
            ->where('i.isClosed = :closed')
//                ->andWhere('DATE_DIFF(:date,i.date) = 15')
//                ->orWhere('DATE_DIFF(:date,i.renotificationDate) = 5')
            ->setParameter('closed', FALSE)
            ->setParameter('date', new \DateTime('-1 days'));

        return $query->getQuery()->getResult();
    }

}