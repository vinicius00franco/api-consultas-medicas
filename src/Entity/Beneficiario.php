<?php

namespace App\Entity;

use App\Repository\BeneficiarioRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Service\Validation\Constraints\Age;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BeneficiarioRepository::class)]
class Beneficiario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['beneficiario'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['beneficiario'])]
    private $nome;

    #[ORM\Column(type: 'string')]
    #[Groups(['beneficiario'])]
    private $email;

    #[ORM\Column(type: 'date')]
    #[Age(message: "O beneficiário deve ter pelo menos 18 anos.")]
    #[Groups(['beneficiario'])]
    private $dataNascimento;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getDataNascimento(): ?DateTimeInterface
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento(DateTimeInterface $dataNascimento): self
    {
        $this->dataNascimento = $dataNascimento;
        return $this;
    }

    public function setFromData(array $data): void
    {
        if (isset($data['nome'])) {
            $this->setNome($data['nome']);
        }
        if (isset($data['email'])) {
            $this->setEmail($data['email']);
        }
        if (isset($data['dataNascimento'])) {
            $this->dataNascimento = new \DateTime($data['dataNascimento']);
        }
    }


    public function getDataNascimentoFormatted(): ?string
    {
        return $this->dataNascimento ? $this->dataNascimento->format('d/m/Y') : null;
    }

    public function getIdade(): ?int
    {
        if ($this->dataNascimento) {
            $hoje = new \DateTime('now');
            $idade = $hoje->diff($this->dataNascimento)->y;
            return $idade;
        }

        return null;
    }
}
