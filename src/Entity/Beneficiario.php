<?php

namespace App\Entity;

use App\Repository\BeneficiarioRepository;
use Doctrine\ORM\Mapping as ORM;

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
    #[Assert\CustomAssert(class: Age::class)]
    private $email;

    #[ORM\Column(type: 'date')]
    private $dataNascimento;
}
