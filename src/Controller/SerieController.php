<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        //TODO afficher le détail d'une série
        return $this->render('serie/detail.html.twig', [
            'serie' => $serie
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(EntityManagerInterface $entityManager): Response
    {
        $serie = new Serie();
        $serie
            ->setBackdrop("backdrop.png")
            ->setDateCreated(new \DateTime())
            ->setGenres("Western")
            ->setName("1883")
            ->setFirstAirDate(new \DateTime("-6 month"))
            ->setLastAirDate(new \DateTime("+6 month"))
            ->setPopularity(200)
            ->setVote(8)
            ->setPoster("poster.png")
            ->setStatus("ended")
            ->setTmdbId(12345);

        dump($serie);
        $entityManager->persist($serie);
        $entityManager->flush();

        dump($serie);

        $serie->setName("K3000");
        $entityManager->persist($serie);
        $entityManager->flush();
        dump($serie);

//        $entityManager->remove($serie);
//        $entityManager->flush();


        //TODO créer une nouvelle série
        return $this->render('serie/add.html.twig');
    }
}
