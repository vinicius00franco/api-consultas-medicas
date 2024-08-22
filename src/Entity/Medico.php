<?php

namespace App\Entity;

use App\Repository\MedicoRepository;
use App\Service\Validation\Constraints\HospitalExists;
use Doctrine\Common\Collections\ArrayCollection;
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
    #[Groups(['medico','consulta'])]
    private $especialidade;

    #[ORM\ManyToOne(targetEntity: Hospital::class, inversedBy: 'medicos')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    // constrants
    #[Assert\Valid]
    #[HospitalExists]
    // serializer
    #[Groups(['medico'])]
    private $hospital;

    #[ORM\Column(type: 'boolean')]
    private $ativo = true;

    public function __construct()
    {
        $this->especialidade = '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }
    public function getEspecialidade(): ?string
    {
        return $this->especialidade;
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

    public function setAtivo(bool $ativo): self
    {
        $this->ativo = $ativo;
        return $this;
    }

    public function isAtivo(): bool
    {
        return $this->ativo;
    }
}
