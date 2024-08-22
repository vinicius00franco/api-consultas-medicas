<?php


namespace App\Service\Validation;

use App\Entity\Consulta;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ConsultaValidator
{
    public function validateUpdate(Consulta $consulta): void
    {
        if ($consulta->isConcluida()) {
            throw new AccessDeniedHttpException('Não é possível alterar uma consulta concluída.');
        }
    }

    public function validateDelete(Consulta $consulta): void
    {
        if ($consulta->isConcluida()) {
            throw new AccessDeniedHttpException('Não é possível excluir uma consulta concluída.');
        }
    }
}
