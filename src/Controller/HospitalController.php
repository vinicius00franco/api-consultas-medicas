<?php

namespace App\Controller;

use App\Entity\Hospital;
use App\Repository\HospitalRepository;
use App\Service\HospitalService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HospitalController extends AbstractController
{
    private $hospitalService;

    public function __construct(HospitalService $hospitalService)
    {
        $this->hospitalService = $hospitalService;
    }

    /**
     * @Route("/hospitals", name="hospital_list", methods={"GET"})
     */
    public function list(): Response
    {
        $hospitais = $this->hospitalService->getAllHospitals();
        
        return new Response(json_encode($hospitais), 200,
                            ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/hospitals", name="hospital_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $hospital = $this->hospitalService->createHospital($data);

        return new Response(json_encode($hospital), 201,
                            ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/hospitals/{id}", name="hospital_update", methods={"PUT"})
     */
    public function update(Hospital $hospitalId, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $hospital = $this->hospitalService->updateHospital($hospitalId, $data);

        return new Response(json_encode($hospital), 200, 
        ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/hospitals/delete/{id}", name="hospital_delete", methods={"DELETE"})
     */
    public function delete(Hospital $hospitalId): Response
    {
        $this->hospitalService->deleteHospital($hospitalId);
        
        return new Response(null, 204);
    }
}
