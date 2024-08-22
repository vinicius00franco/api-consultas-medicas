<?php

namespace App\Entity;

use App\Repository\MedicoRepository;
use App\Service\Validation\Constraints\HospitalExists;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\MaxDepth;

#[ORM\Entity(repositoryClass: MedicoRepository::class)]
class Medico
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['medico'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['medico'])]
    private $nome;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['medico'])]
    private $especialidade;

    #[ORM\ManyToOne(targetEntity: Hospital::class, inversedBy: 'medicos')]
    #[ORM\JoinColumn(nullable: false)]
    // constrants
    #[Assert\Valid]
    #[HospitalExists]
    // serializer
    #[MaxDepth(1)]
    #[Groups(['medico'])]
    private $hospital;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getHospital(): ?Hospital
    {
        return $this->hospital;
    }

    public function setHospital(?Hospital $hospital): self
    {
        $this->hospital = $hospital;

        return $this;
    }

    public function setEspecialidade(string $especialidade): self
    {
        $this->especialidade = $especialidade;

        return $this;
    }
}
