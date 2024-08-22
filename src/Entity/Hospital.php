<?php

namespace App\Entity;

use App\Repository\HospitalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: HospitalRepository::class)]
class Hospital
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['hospital'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['hospital'])]
    private $nome;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['hospital'])]
    private $endereco;

    #[ORM\OneToMany(targetEntity: Medico::class, mappedBy: 'hospital')]
    #[Groups(['hospital'])]
    private $medicos;

    public function __construct()
    {
        $this->medicos = new ArrayCollection();
    }

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

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): self
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * @return Collection|Medico[]
     */
    public function getMedicos(): Collection
    {
        return $this->medicos;
    }

    public function addMedico(Medico $medico): self
    {
        if (!$this->medicos->contains($medico)) {
            $this->medicos[] = $medico;
            $medico->setHospital($this);
        }

        return $this;
    }

    public function removeMedico(Medico $medico): self
    {
        if ($this->medicos->removeElement($medico)) {
            // set the owning side to null (unless already changed)
            if ($medico->getHospital() === $this) {
                $medico->setHospital(null);
            }
        }

        return $this;
    }
}
