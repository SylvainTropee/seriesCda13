<?php

namespace App\Controller\Api;

use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/serie', name: 'api_serie_')]
final class SerieController extends AbstractController
{
    #[Route('', name: 'list', methods: 'GET')]
    public function list(SerieRepository $serieRepository): Response
    {
        $series = $serieRepository->findAll();
        return $this->json($series, Response::HTTP_OK, [], ['groups' => 'getSerie']);

    }
    #[Route('/{id}', name: 'detail', methods: 'GET')]
    public function detail(SerieRepository $serieRepository, int $id): Response
    {
        $serie = $serieRepository->find($id);
        return $this->json($serie, Response::HTTP_OK, [], ['groups' => 'getSerie']);
    }

    #[Route('', name: 'add', methods: 'POST')]
    public function add(): Response
    {

    }
    #[Route('/{id}', name: 'update', methods: ['PUT', 'PATCH'])]
    public function update(): Response
    {

    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(): Response
    {

    }
}
