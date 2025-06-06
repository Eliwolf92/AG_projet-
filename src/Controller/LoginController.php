<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LoginController extends AbstractController
{   //https://127.0.0.1:8000/login
    #[Route('login', name: 'app_login')]
    public function index(): Response
    {
        return $this->render('Pages_Connexion_Inscription/Login.html.twig', [
            'controller_name' => 'LoginController',
        ]);

        
    }
}
