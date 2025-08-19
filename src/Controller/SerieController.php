<?php

namespace App\Controller;

use App\Entity\Serie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/TV-show', name: 'tv_show_')]
final class SerieController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(): Response
    {
        //TODO afficher la liste des séries
        return $this->render('serie/list.html.twig');
    }

    #[Route('/{id}', name: 'detail', requirements: ['id' => '\d+'])]
    public function detail(int $id): Response
    {
        dump($id);

        //TODO afficher le détail d'une série
        return $this->render('serie/detail.html.twig');
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

        $serie->setName("K2000");
        $entityManager->persist($serie);
        $entityManager->flush();
        dump($serie);

        //TODO créer une nouvelle série
        return $this->render('serie/add.html.twig');
    }
}
