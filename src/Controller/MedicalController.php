<?php
namespace App\Controller;

use App\Repository\MedicoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MedicalController
{
    private $medicoRepository;

    public function __construct(MedicoRepository $medicoRepository)
    {
        $this->medicoRepository = $medicoRepository;
    }

    public function list(): Response
    {
        $medicos = $this->medicoRepository->findAll();
        return new Response(json_encode($medicos), 200, ['Content-Type' => 'application/json']);
    }

    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $medico = $this->medicoRepository->create($data);
        return new Response(json_encode($medico), 201, ['Content-Type' => 'application/json']);
    }

    public function update(int $id, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $medico = $this->medicoRepository->update($id, $data);
        return new Response(json_encode($medico), 200, ['Content-Type' => 'application/json']);
    }

    public function delete(int $id): Response
    {
        $this->medicoRepository->delete($id);
        return new Response(null, 204);
    }
}
