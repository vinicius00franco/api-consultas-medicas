<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Repository\HospitalRepository;

/**
 * @Annotation
 */
class HospitalExists extends Constraint
{
    public $message = 'O hospital selecionado não existe.';
}