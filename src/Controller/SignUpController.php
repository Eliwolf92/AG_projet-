<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SignUpController extends AbstractController
{
    #[Route('sign/up', name: 'app_sign_up')]
    public function index(): Response
    {
        return $this->render('Pages_Connexion_Inscription/Sign_Up.html.twig', [
            'controller_name' => 'SignUpController',
        ]);
    }
}
