<?php

namespace App\Controller\Api;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function add(
        Request                $request,
        SerializerInterface    $serializer,
        EntityManagerInterface $entityManager,
        ValidatorInterface     $validator
    ): Response
    {
        $data = $request->getContent();
        $serie = $serializer->deserialize($data, Serie::class, 'json');

        $errors = $validator->validate($serie);
        if (count($errors) > 0) {
            return $this->json($serializer->serialize($errors, 'json'));
        }

        $entityManager->persist($serie);
        $entityManager->flush();

        return $this->json($serie, Response::HTTP_CREATED, [], ['groups' => 'getSerie']);

    }

    #[Route('/{id}', name: 'update', methods: ['PUT', 'PATCH'])]
    public function update(
        int $id,
        Request $request,
        SerieRepository $serieRepository,
        EntityManagerInterface $entityManager): Response
    {
        $data = $request->getContent();
        $data = json_decode($data);

        $serie = $serieRepository->find($id);
        $serie->setNbLike($serie->getNbLike() + $data->like);

        $entityManager->persist($serie);
        $entityManager->flush();

        return $this->json($serie, Response::HTTP_OK, [], ['groups' => 'getSerie']);

    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(
        int                    $id,
        EntityManagerInterface $entityManager,
        SerieRepository        $serieRepository): Response
    {

        $serie = $serieRepository->find($id);
        $entityManager->remove($serie);
        $entityManager->flush();

        return $this->json('Serie deleted !', Response::HTTP_NO_CONTENT);
    }
}
