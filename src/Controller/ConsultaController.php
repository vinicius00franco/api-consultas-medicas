<?php

namespace App\Controller;

use App\Entity\Consulta;
use App\Repository\ConsultaRepository;
use App\Service\ConsultaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;


class ConsultaController extends AbstractController
{
    private $consultaService;
    

    public function __construct(ConsultaService $consultaService)
    {
        $this->consultaService = $consultaService;
    }

    public function list(): JsonResponse
    {
        $consultas = $this->consultaService->getAllConsultas();
        return new JsonResponse($consultas, Response::HTTP_OK);
    }

    #[Route('/consultas/create', name: 'consulta_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        

        try {
            $consulta = $this->consultaService->createConsulta($data);

            return new Response(json_encode($consulta), Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Consulta $consulta, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        try {
            $consulta = $this->consultaService->updateConsulta($consulta, $data);
            return new Response(json_encode($consulta), Response::HTTP_OK, ['Content-Type' => 'application/json']);
        } catch (AccessDeniedHttpException $e) {
            return new Response($e->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    #[Route('/consultas/delete/{id}', name: 'consulta_delete', methods: ['DELETE'])]
    public function delete(Consulta $consulta): Response
    {
        try {
            $this->consultaService->deleteConsulta($consulta);
            return new Response(null, Response::HTTP_NO_CONTENT);
        } catch (AccessDeniedHttpException $e) {
            return new Response($e->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }  
    
}
