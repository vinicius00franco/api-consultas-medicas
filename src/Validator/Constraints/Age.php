<?php

namespace App\Validator\Atributtes;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Age extends Constraint
{
    public $message = 'O beneficiário deve ter pelo menos 18 anos.';

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}
