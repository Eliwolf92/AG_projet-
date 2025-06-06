<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ForgotpassController extends AbstractController
{
    #[Route('/forgotpass', name: 'app_forgotpass')]
    public function index(): Response
    {
        return $this->render('Pages_Connexion_Inscription/forgotpass.html.twig', [
            'controller_name' => 'ForgotpassController',
        ]);
    }
}
