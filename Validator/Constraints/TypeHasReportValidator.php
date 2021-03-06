<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TypeHasReportValidator extends ConstraintValidator
{

    private $lang;

    public function __construct(string $lang)
    {
        $this->lang = $lang;
    }

    public function validate($type, Constraint $constraint)
    {

        if ($type && !$type->getReport($this->lang) && $type->getSlug() !== 'undefined' && !empty($constraint->message)) {
            $this->context->addViolation(
                $constraint->message, array('%string%' => $this->lang)
            );
        }
    }

}
