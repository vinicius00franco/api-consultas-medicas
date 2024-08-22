<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Repository\HospitalRepository;


#[\Attribute]
class HospitalExists extends Constraint
{
    public $message = 'O hospital selecionado não existe.';

    public function __construct(string $message = null, array $groups = null, mixed $payload = null)
    {
        parent::__construct($groups, $payload);
        $this->message = $message ?? $this->message;
    }

    public function validatedBy(): string
    {
        return \App\Validator\HospitalExistsValidator::class;
    }
}