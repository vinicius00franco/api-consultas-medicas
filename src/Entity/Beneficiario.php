<?php

namespace App\Entity;

use App\Repository\BeneficiarioRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\Atributtes\Age;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BeneficiarioRepository::class)]
class Beneficiario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nome;

    #[ORM\Column(type: 'string')]
    
    private $email;

    #[ORM\Column(type: 'date')]
    #[Age(message: "O beneficiário deve ter pelo menos 18 anos.")]
    private $dataNascimento;

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getDataNascimento(): ?\DateTimeInterface
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento(\DateTimeInterface $dataNascimento): self
    {
        $this->dataNascimento = $dataNascimento;
        return $this;
    }
}
