<?php

namespace App\Controller;

use App\Entity\Beneficiario;
use App\Service\BeneficiarioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BeneficiarioController extends AbstractController
{
    private $beneficiarioService;

    public function __construct(BeneficiarioService $beneficiarioService)
    {
        $this->beneficiarioService = $beneficiarioService;
    }

    /**
     * @Route("/beneficiarios", methods={"GET"})
     */
    public function list(): JsonResponse
    {
        $beneficiarios = $this->beneficiarioService->getAllBeneficiarios();

        return new JsonResponse($beneficiarios, Response::HTTP_OK);
    }

    /**
     * @Route("/beneficiarios/create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse(['error' => 'Invalid input'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $beneficiario = $this->beneficiarioService->createBeneficiario($data);

            return new JsonResponse($beneficiario, Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/beneficiarios/{id}", methods={"PUT"})
     */
    public function update(Request $request, Beneficiario $beneficiario): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse(['error' => 'Invalid input'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $beneficiario = $this->beneficiarioService->updateBeneficiario($beneficiario, $data);

            return new JsonResponse($beneficiario, Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/beneficiarios/delete/{id}", methods={"DELETE"})
     */
    public function delete(Beneficiario $beneficiario): JsonResponse
    {
        $this->beneficiarioService->deleteBeneficiario($beneficiario);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
