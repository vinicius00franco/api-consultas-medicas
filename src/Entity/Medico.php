<?php

namespace App\Entity;

use App\Repository\MedicoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicoRepository::class)]
class Medico
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nome;

    #[ORM\Column(type: 'string', length: 255)]
    private $especialidade;

    #[ORM\ManyToOne(targetEntity: Hospital::class, inversedBy: 'medicos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\CustomAssert(class: HospitalExists::class)]
    private $hospital;
}
