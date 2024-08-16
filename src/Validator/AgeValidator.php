<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use DateTime;

class AgeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$value) {
            return;
        }

        $age = $this->calculateAge($value);

        if ($age < 18) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }

    private function calculateAge(DateTime $birthDate)
    {
        $now = new DateTime();
        $interval = $now->diff($birthDate);
        return $interval->y;
    }
}
