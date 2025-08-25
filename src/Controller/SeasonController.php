<?php

namespace App\Controller;

use App\Entity\Season;
use App\Form\SeasonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/season', name: 'season_')]
final class SeasonController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $season = new Season();
        $seasonForm = $this->createForm(SeasonType::class, $season);
        $seasonForm->handleRequest($request);

        dump($season);

        if($seasonForm->isSubmitted() && $seasonForm->isValid()){

            $season->setDateCreated(new \DateTime());
            $entityManager->persist($season);
            $entityManager->flush();

            $this->addFlash('success', 'Season added !');
            return $this->redirectToRoute('tv_show_detail', ['id' => $season->getSerie()->getId() ]);
        }

        return $this->render('season/add.html.twig', [
            'seasonForm' => $seasonForm
        ]);
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => '\d+'])]
    public function update(int $id): Response
    {
        return $this->render('season/update.html.twig');
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => '\d+'])]
    public function delete(int $id): Response
    {
        return $this->redirectToRoute('tv_show_list');
    }

}
