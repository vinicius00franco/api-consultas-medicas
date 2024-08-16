<?php

namespace App\Entity;

use App\Repository\HospitalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HospitalRepository::class)]
class Hospital
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nome;

    #[ORM\Column(type: 'string', length: 255)]
    private $endereco;

    #[ORM\OneToMany(targetEntity: Medico::class, mappedBy: 'hospital')]
    private $medicos;

    public function __construct()
    {
        $this->medicos = new ArrayCollection();
    }
}
