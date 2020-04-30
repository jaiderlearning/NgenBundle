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

use CertUnlp\NgenBundle\Entity\Communication\TelegramMessage;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * TelegramMessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TelegramMessageRepository extends MessageRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TelegramMessage::class);
    }

}
