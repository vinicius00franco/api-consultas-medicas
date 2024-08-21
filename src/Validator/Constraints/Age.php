<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Age extends Constraint
{
    public string $message = 'O beneficiário deve ter pelo menos 18 anos.';

    public function __construct(string $message = null, array $groups = null, mixed $payload = null)
    {
        parent::__construct($groups, $payload);
        $this->message = $message ?? $this->message;
    }

    public function validatedBy(): string
    {
        return \App\Validator\AgeValidator::class;
    }
}
