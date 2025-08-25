<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/TV-show', name: 'tv_show_')]
final class SerieController extends AbstractController
{
    #[Route('/{page}', name: 'list', requirements: ['page' => '\d+'])]
    public function list(SerieRepository $serieRepository, int $page = 1): Response
    {
        //récupére tout
        //$series = $serieRepository->findAll();
        //$series = $serieRepository->findBestSeries();
        //récupère les 50 series les mieux votées
        //$series = $serieRepository->findBy([], ["popularity" => "DESC"], 50);

        $nbSeries = $serieRepository->count();
        $maxPage = ceil($nbSeries / Serie::SERIE_PER_PAGE);

        if ($page < 1) {
            return $this->redirectToRoute('tv_show_list', ['page' => 1]);
        }
        if ($page > $maxPage) {
            return $this->redirectToRoute('tv_show_list', ['page' => $maxPage]);
        }

        $series = $serieRepository->findBestSeriesWithPagination($page);

        return $this->render('serie/list.html.twig', [
            "series" => $series,
            "currentPage" => $page,
            'maxPage' => $maxPage
        ]);
    }

    #[Route('/detail/{id}', name: 'detail', requirements: ['id' => '\d+'])]
    public function detail(int $id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);

        if (!$serie) {
            throw $this->createNotFoundException("Oops ! Serie not found !");
        }

        dump($serie);

        //TODO afficher le détail d'une série
        return $this->render('serie/detail.html.twig', [
            'serie' => $serie
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(EntityManagerInterface $entityManager, Request $request): Response
    {
        $serie = new Serie();
        $serieForm = $this->createForm(SerieType::class, $serie);

        $serieForm->handleRequest($request);

        if($serieForm->isSubmitted() && $serieForm->isValid()){
            //$serie->setDateCreated(new \DateTime());
            //enregistrement des données
            $entityManager->persist($serie);
            $entityManager->flush();

            $this->addFlash("success", "Serie : " . $serie->getName() . " added !");
            return $this->redirectToRoute('tv_show_detail', ['id' => $serie->getId()]);
        }

        return $this->render('serie/add.html.twig', [
            'serieForm' => $serieForm
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => '\d+'])]
    public function delete(
        int $id,
        SerieRepository $serieRepository,
        EntityManagerInterface $entityManager): Response
    {
        $serie = $serieRepository->find($id);

        if (!$serie) {
            throw $this->createNotFoundException("Oops ! Serie not found !");
        }

        $entityManager->remove($serie);
        $entityManager->flush();
        $this->addFlash('success', 'Serie deleted !');

        return $this->redirectToRoute('tv_show_list');
    }





}
