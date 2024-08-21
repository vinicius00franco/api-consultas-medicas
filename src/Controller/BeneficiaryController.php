<?php

namespace App\Controller;

use App\Entity\Beneficiario;
use App\Repository\BeneficiarioRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BeneficiaryController
{
    private $beneficiarioRepository;

    public function __construct(BeneficiarioRepository $beneficiarioRepository)
    {
        $this->beneficiarioRepository = $beneficiarioRepository;
    }

    public function list(): Response
    {
        $beneficiarios = $this->beneficiarioRepository->findAll();
        return new Response(json_encode($beneficiarios), 200, ['Content-Type' => 'application/json']);
    }

    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $beneficiario = $this->beneficiarioRepository->create($data);
        return new Response(json_encode($beneficiario), 201, ['Content-Type' => 'application/json']);
    }

    public function update(Beneficiario $beneficiaryId, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $beneficiario = $this->beneficiarioRepository->update($beneficiaryId, $data);
        return new Response(json_encode($beneficiario), 200, ['Content-Type' => 'application/json']);
    }

    public function delete(Beneficiario $beneficiaryId): Response
    {
        $this->beneficiarioRepository->delete($beneficiaryId);
        return new Response(null, 204);
    }
}
