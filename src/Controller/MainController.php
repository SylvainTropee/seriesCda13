<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('', name: 'main_home')]
    #[Route('/home', name: 'main_home_2')]
    public function home(): Response
    {
        return $this->render("main/home.html.twig");

    }

    #[Route('/test', name: 'main_test')]
    public function test(): Response
    {
        $user = "<h1>Sylvain</h1>";
        $serie = [
            "title" => "Prison Break",
            "nbSeason" => 5,
            "description" => "Des gens s'échappent de prison et y retournent, et se rééchappent..."
        ];
        $date = new \DateTime();

        return $this->render("main/test.html.twig", [
            "username" => $user,
            "serieTV" => $serie,
            "date" => $date
        ]);
    }

}
