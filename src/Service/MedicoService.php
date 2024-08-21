<?php
namespace App\Service;

use App\Repository\MedicoRepository;
use App\Entity\Medico;

class MedicoService
{
    private $medicoRepository;

    public function __construct(MedicoRepository $medicoRepository)
    {
        $this->medicoRepository = $medicoRepository;
    }

    public function findAll(): array
    {
        return $this->medicoRepository->findAll();
    }

    public function create(array $data): Medico
    {
        // Assuming that $data contains the necessary fields to create a Medico entity.
        $medico = new Medico();
        // Set properties of $medico from $data
        // For example: $medico->setName($data['name']);
        
        $this->medicoRepository->save($medico); // Custom method to save the entity
        return $medico;
    }

    public function update(int $id, array $data): ?Medico
    {
        $medico = $this->medicoRepository->find($id);
        if (!$medico) {
            return null;
        }
        // Update properties of $medico from $data
        // For example: $medico->setName($data['name']);
        
        $this->medicoRepository->save($medico); // Custom method to save the updated entity
        return $medico;
    }

    public function delete(int $id): void
    {
        $medico = $this->medicoRepository->find($id);
        if ($medico) {
            $this->medicoRepository->remove($medico); // Custom method to remove the entity
        }
    }
}
