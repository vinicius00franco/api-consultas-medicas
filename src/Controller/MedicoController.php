<?php
namespace App\Controller;

use App\Service\MedicoService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MedicoController
{
    private $medicoService;

    public function __construct(MedicoService $medicoService)
    {
        $this->medicoService = $medicoService;
    }

    public function list(): Response
    {
        $medicos = $this->medicoService->findAll();
        return new Response(json_encode($medicos), 200, ['Content-Type' => 'application/json']);
    }

    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $medico = $this->medicoService->create($data);
        return new Response(json_encode($medico), 201, ['Content-Type' => 'application/json']);
    }

    public function update(int $id, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $medico = $this->medicoService->update($id, $data);
        if (!$medico) {
            return new Response('Not Found', 404);
        }
        return new Response(json_encode($medico), 200, ['Content-Type' => 'application/json']);
    }

    public function delete(int $id): Response
    {
        $this->medicoService->delete($id);
        return new Response(null, 204);
    }
}
