<?php

namespace App\Service\Validation\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Repository\HospitalRepository;
use App\Service\Validation\HospitalExistsValidator;


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
        return HospitalExistsValidator::class;
    }
}