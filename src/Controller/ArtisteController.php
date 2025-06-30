<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ArtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArtisteController extends AbstractController
{
    #[Route('/artiste/{id}', name: 'app_artiste_page')]
    public function index(User $user, ArtRepository $artRepository): Response
    {
        $arts = $artRepository->findBy(['artiste' => $user]);

        return $this->render('artiste/index.html.twig', [
            'artiste' => $user,
            'arts' => $arts,
        ]);
    }

    
}
