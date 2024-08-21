<?php

namespace App\Controller;

use App\Entity\Beneficiario;
use App\Repository\BeneficiarioRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BeneficiarioController
{
    private $beneficiarioRepository;

    public function __construct(BeneficiarioRepository $beneficiarioRepository)
    {
        $this->beneficiarioRepository = $beneficiarioRepository;
    }

    /**
     * @Route("/beneficiarios", methods={"GET"})
     */
    public function list(): Response
    {
        $beneficiarios = $this->beneficiarioRepository->findAll();
        return new Response(json_encode($beneficiarios), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/beneficiarios", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new Response('Invalid input', 400);
        }

        $beneficiario = $this->beneficiarioRepository->create($data);
        return new Response(json_encode($beneficiario), 201, ['Content-Type' => 'application/json']);
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
        return new Response(json_encode($beneficiario), 200, ['Content-Type' => 'application/json']);
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
