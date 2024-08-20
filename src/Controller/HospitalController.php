<?php

namespace App\Controller;

use App\Repository\HospitalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HospitalController
{
    private $hospitalRepository;

    public function __construct(HospitalRepository $hospitalRepository)
    {
        $this->hospitalRepository = $hospitalRepository;
    }

    public function list(): Response
    {
        $hospitais = $this->hospitalRepository->findAll();
        return new Response(json_encode($hospitais), 200, ['Content-Type' => 'application/json']);
    }

    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $hospital = $this->hospitalRepository->create($data);
        return new Response(json_encode($hospital), 201, ['Content-Type' => 'application/json']);
    }

    public function update(int $id, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $hospital = $this->hospitalRepository->update($id, $data);
        return new Response(json_encode($hospital), 200, ['Content-Type' => 'application/json']);
    }

    public function delete(int $id): Response
    {
        $this->hospitalRepository->delete($id);
        return new Response(null, 204);
    }
}
