<?php

namespace App\Service\Pattern;

use App\Entity\Consulta;

interface ConsultaServiceInterface
{
    public function getAllConsultas(): array;
    public function getConsultaById(Consulta $consulta): ?array;
    public function createConsulta(array $data): array;
    public function updateConsulta(Consulta $consulta, array $data): array;
    public function deleteConsulta(Consulta $consulta): void;
}

