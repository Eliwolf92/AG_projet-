<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArtistePageController extends AbstractController
{
    #[Route('/artiste/page', name: 'app_artiste_page')]
    public function index(): Response
    {
        return $this->render('artiste_page/index.html.twig', [
            'controller_name' => 'ArtistePageController',
        ]);
    }
}
