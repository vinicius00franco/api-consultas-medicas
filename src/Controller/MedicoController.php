<?php
namespace App\Controller;

use App\Entity\Medico;
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

    /**
     * @Route("/medicos", name="medico_list", methods={"GET"})
     */
    public function list(): Response
    {
        $medicos = $this->medicoService->getAllMedicos();

        var_dump($medicos);
        return new Response(json_encode($medicos), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/medicos/create", name="medico_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $medico = $this->medicoService->createMedico($data);
        return new Response(json_encode($medico), 201, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/medicos/{medicoId}", name="medico_update", methods={"PUT"})
     */
    public function update(Medico $medicoId, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $medico = $this->medicoService->updateMedico($medicoId, $data);
        if (!$medico) {
            return new Response('Not Found', 404);
        }
        return new Response(json_encode($medico), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/medicos/delete/{id}", name="medico_delete", methods={"DELETE"})
     */
    public function delete(Medico $medicoId): Response
    {
        $this->medicoService->deleteMedico($medicoId);
        return new Response(null, 204);
    }
}
