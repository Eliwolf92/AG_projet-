<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{   
    //https://127.0.0.1:8000/index
    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('Pages/Main.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
