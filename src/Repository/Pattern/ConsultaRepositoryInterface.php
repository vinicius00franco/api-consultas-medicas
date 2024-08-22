<?php


namespace App\Repository\Pattern;

use App\Entity\Consulta;

interface ConsultaRepositoryInterface
{
    public function findAll(): array;
    public function findById(Consulta $consulta): ?Consulta;
    public function createConsulta(array $data): Consulta;

    public function removeConsulta(Consulta $consulta): void;

    public function updateConsulta(Consulta $consulta, array $data): Consulta;

}
