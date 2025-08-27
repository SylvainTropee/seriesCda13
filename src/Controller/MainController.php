<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class MainController extends AbstractController
{
    #[Route('', name: 'main_home')]
    #[Route('/home', name: 'main_home_2')]
    public function home(): Response
    {
        return $this->render("main/home.html.twig");

    }

    #[Route('/test', name: 'main_test')]
    public function test(SerializerInterface $serializer): Response
    {
        $user = "<h1>Sylvain</h1>";
        $serie = [
            "title" => "Prison Break",
            "nbSeason" => 5,
            "description" => "Des gens s'échappent de prison et y retournent, et se rééchappent..."
        ];
        $date = new \DateTime();


        $fact = file_get_contents("https://uselessfacts.jsph.pl/api/v2/facts/random");
        dump(json_decode($fact));
        dump(json_decode($fact, true));
        //dump($serializer->deserialize($fact, null, 'json'));

        return $this->render("main/test.html.twig", [
            "username" => $user,
            "serieTV" => $serie,
            "date" => $date
        ]);
    }

}
