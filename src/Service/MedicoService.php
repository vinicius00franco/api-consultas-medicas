<?php
namespace App\Service;

use App\Repository\MedicoRepository;
use App\Entity\Medico;
use Doctrine\ORM\EntityNotFoundException;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MedicoService
{
    private $medicoRepository;
    private $serializer;
    private $normalizer;

    public function __construct(MedicoRepository $medicoRepository, SerializerInterface $serializer, NormalizerInterface $normalizer)
    {
        $this->medicoRepository = $medicoRepository;
        $this->serializer = $serializer;
        $this->normalizer = $normalizer;
    }

    public function getAllMedicos(): array
    {
        $medicos = $this->medicoRepository->findAll();
        return $this->normalizer->normalize($medicos, null, ['groups' => ['medico', 'hospital'],
        'circular_reference_handler' => function ($object) {
            return $object->getId(); // Retorna o ID do objeto para evitar referência circular
        },
    ]);
    }

    public function createMedico(array $data): Medico
    {
        return $this->medicoRepository->create($data);
    }

    public function updateMedico(Medico $medicoId, array $data): Medico
    {
        return $this->medicoRepository->update($medicoId, $data);
    }

    public function deleteMedico(Medico $medicoId): void
    {
        $medico = $this->medicoRepository->findById($medicoId);

        if (!$medico) {
            throw new EntityNotFoundException('Medico not found.');
        }

        $this->medicoRepository->delete($medico);
    }

    public function getMedicoById(Medico $medicoId): Medico
    {
        $medico = $this->medicoRepository->findById($medicoId);

        if (!$medico) {
            throw new EntityNotFoundException('Medico not found.');
        }

        return $medico;
    }
}
