<?php

namespace App\Controller;

use App\Repository\HospitalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HospitalController extends AbstractController
{
    private $hospitalRepository;

    public function __construct(HospitalRepository $hospitalRepository)
    {
        $this->hospitalRepository = $hospitalRepository;
    }

    /**
     * @Route("/hospitals", name="hospital_list", methods={"GET"})
     */
    public function list(): Response
    {
        $hospitais = $this->hospitalRepository->findAll();
        return new Response(json_encode($hospitais), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/hospitals", name="hospital_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $hospital = $this->hospitalRepository->create($data);
        return new Response(json_encode($hospital), 201, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/hospitals/{id}", name="hospital_update", methods={"PUT"})
     */
    public function update(int $id, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $hospital = $this->hospitalRepository->update($id, $data);
        return new Response(json_encode($hospital), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/hospitals/{id}", name="hospital_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $this->hospitalRepository->delete($id);
        return new Response(null, 204);
    }
}
