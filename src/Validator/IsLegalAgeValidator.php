<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsLegalAgeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\IsLegalAge */

        if (null === $value || '' === $value) {
            return;
        }

        $today = new \DateTime('now');
        $interval = $value->diff($today);
        $totalYears = intval($interval->format('%y'));

        if ($totalYears < 18) {
            $this->context->buildViolation($constraint->message)
            ->addViolation();
        }
    }
}
