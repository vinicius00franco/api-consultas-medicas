<?php

namespace App\Controller;

use App\Entity\Beneficiario;
use App\Service\BeneficiarioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class BeneficiarioController extends AbstractController
{
    private $beneficiarioService;
    private $serializer;

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

        // Serialize the list of Beneficiarios to JSON using the 'beneficiario' group
        $jsonBeneficiarios = $this->beneficiarioService->formatBeneficiarios($beneficiarios);

        return new JsonResponse($jsonBeneficiarios, Response::HTTP_OK, []);
    }

    /**
     * @Route("/beneficiarios/create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new Response('Invalid input', 400);
        }

        try {
            $beneficiario = $this->beneficiarioService->createBeneficiario($data);

            $jsonBeneficiario = $this->serializer->serialize($beneficiario, 'json', [
                AbstractNormalizer::GROUPS => ['beneficiario']
            ]);

            return new Response($jsonBeneficiario, 201, ['Content-Type' => 'application/json']);
        } catch (\InvalidArgumentException $e) {
            return new Response($e->getMessage(), 400);
        }
    }

    /**
     * @Route("/beneficiarios/{id}", methods={"PUT"})
     */
    public function update(Request $request, Beneficiario $beneficiario): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new Response('Invalid input', 400);
        }

        try {
            $beneficiario = $this->beneficiarioService->updateBeneficiario($beneficiario, $data);

            $jsonBeneficiario = $this->serializer->serialize($beneficiario, 'json', [
                AbstractNormalizer::GROUPS => ['beneficiario']
            ]);

            return new Response($jsonBeneficiario, 200, ['Content-Type' => 'application/json']);
        } catch (\InvalidArgumentException $e) {
            return new Response($e->getMessage(), 400);
        }
    }

    /**
     * @Route("/beneficiarios/delete/{id}", methods={"DELETE"})
     */
    public function delete(Beneficiario $beneficiario): Response
    {
        $this->beneficiarioService->deleteBeneficiario($beneficiario);
        return new Response(null, 204);
    }
}
