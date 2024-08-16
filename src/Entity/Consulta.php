<?php

namespace App\Entity;

use App\Repository\ConsultaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultaRepository::class)]
class Consulta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $data;

    #[ORM\Column(type: 'string', length: 50)]
    private $status;

    #[ORM\ManyToOne(targetEntity: Beneficiario::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $beneficiario;

    #[ORM\ManyToOne(targetEntity: Medico::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $medico;

    #[ORM\ManyToOne(targetEntity: Hospital::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $hospital;
}
