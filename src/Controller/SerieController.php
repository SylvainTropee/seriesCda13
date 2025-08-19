<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/TV-show', name: 'tv_show_' )]
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
    public function add(): Response
    {
        //TODO créer une nouvelle série
        return $this->render('serie/add.html.twig');
    }
}
