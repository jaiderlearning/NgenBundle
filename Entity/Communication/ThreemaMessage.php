<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Communication;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThreemaMessage
 *
 * @author einar
 * @ORM\Entity()
 */
class ThreemaMessage extends Message
{

    public function isThreema(): bool
    {
        return true;
    }


}