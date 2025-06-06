<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BaseMainController extends AbstractController
{
    #[Route('/base/main', name: 'app_base_main')]
    public function index(): Response
    {               
            $username = '...';
            $userNotifications = ['...', '...'];


        return $this->render('base.html.twig', [
            'controller_name' => 'BaseMainController',
            'username' => $username,
            'userNotifications' => $userNotifications,
        ]);

        
    }
}
