<?php

namespace App\Controller;

use App\Entity\Consulta;
use App\Repository\ConsultaRepository;
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
    private $consultaRepository;
    private $entityManager;
    

    public function __construct(ConsultaRepository $consultaRepository,EntityManagerInterface $entityManager)
    {
        $this->consultaRepository = $consultaRepository;
        $this->entityManager = $entityManager;
    }

    public function list(): JsonResponse
    {
        $consultas = $this->consultaRepository->findAll();
        return $this->json($consultas);
    }

    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Implementar validação de dados aqui
        if (new \DateTime($data['data']) > new \DateTime()) {
            return new Response('Data inválida', Response::HTTP_BAD_REQUEST);
        }

        $consulta = new Consulta();
        $consulta->setDataNascimento(new \DateTime($data['data']));
        $consulta->setStatus($data['status']);
        $consulta->setBeneficiario($this->entityManager->getReference('App:Beneficiario', $data['beneficiario']));
        $consulta->setMedico($this->entityManager->getReference('App:Medico', $data['medico']));
        $consulta->setHospital($this->entityManager->getReference('App:Hospital', $data['hospital']));

        $this->entityManager->persist($consulta);
        $this->entityManager->flush();

        return new Response('Consulta criada com sucesso!', Response::HTTP_CREATED);
    }

    public function update(Request $request, $id): Response
    {
        // Busca a consulta pelo ID
        $consulta = $this->consultaRepository->find($id);

        // Verifica se a consulta existe
        if (!$consulta) {
            throw new NotFoundHttpException('Consulta não encontrada.');
        }

        // Decodifica os dados do corpo da requisição
        $data = json_decode($request->getContent(), true);

        try {
            // Tenta atualizar a consulta
            $this->consultaRepository->updateConsulta($consulta, $data);
            return new Response('Consulta atualizada com sucesso.', Response::HTTP_OK);
        } catch (AccessDeniedHttpException $e) {
            // Retorna uma resposta de erro se a consulta estiver concluída
            return new Response($e->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function delete($id): Response
    {
        // Busca a consulta pelo ID
        $consulta = $this->consultaRepository->find($id);

        // Verifica se a consulta existe
        if (!$consulta) {
            throw new NotFoundHttpException('Consulta não encontrada.');
        }

        try {
            // Tenta remover a consulta
            $this->consultaRepository->removeConsulta($consulta);
            return new Response('Consulta excluída com sucesso.', Response::HTTP_OK);
        } catch (AccessDeniedHttpException $e) {
            // Retorna uma resposta de erro se a consulta estiver concluída
            return new Response($e->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
