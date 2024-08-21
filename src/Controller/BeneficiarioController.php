<?php

namespace App\Controller;

use App\Entity\Beneficiario;
use App\Repository\BeneficiarioRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class BeneficiarioController
{
    private $beneficiarioRepository;
    private $serializer;

    public function __construct(BeneficiarioRepository $beneficiarioRepository, SerializerInterface $serializer)
    {
        $this->beneficiarioRepository = $beneficiarioRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/beneficiarios", methods={"GET"})
     */
    public function list(): Response
    {
        $beneficiarios = $this->beneficiarioRepository->findAll();

        $jsonBeneficiarios = $this->serializer->serialize($beneficiarios, 'json', [
            AbstractNormalizer::GROUPS => ['beneficiario']
        ]);

        return new Response($jsonBeneficiarios, 200, ['Content-Type' => 'application/json']);
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

        $beneficiario = $this->beneficiarioRepository->create($data);

        $jsonBeneficiario = $this->serializer->serialize($beneficiario, 'json', [
            AbstractNormalizer::GROUPS => ['beneficiario']
        ]);

        return new Response(json_encode($jsonBeneficiario), 201, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/beneficiarios/{id}", methods={"PUT"})
     */
    public function update(Beneficiario $beneficiario, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new Response('Invalid input', 400);
        }

        $beneficiario = $this->beneficiarioRepository->update($beneficiario, $data);

        $jsonBeneficiario = $this->serializer->serialize($beneficiario, 'json', [
            AbstractNormalizer::GROUPS => ['beneficiario']
        ]);

        return new Response(json_encode($jsonBeneficiario), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/beneficiarios/{id}", methods={"DELETE"})
     */
    public function delete(Beneficiario $beneficiario): Response
    {
        $this->beneficiarioRepository->delete($beneficiario);
        return new Response(null, 204);
    }
}
