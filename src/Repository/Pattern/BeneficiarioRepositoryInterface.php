<?php

namespace App\Repository\Pattern;

use App\Entity\Beneficiario;

interface BeneficiarioRepositoryInterface
{
    public function findAll(): array;
    public function create(Beneficiario $beneficiario): Beneficiario;
    public function update(Beneficiario $beneficiario, array $data): Beneficiario;
    public function delete(Beneficiario $beneficiario): void;
}
