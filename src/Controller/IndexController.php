<?php

namespace App\Controller;

use Dom\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArtRepository;
use App\Repository\CategoriesRepository;

final class IndexController extends AbstractController
{   
    //https://127.0.0.1:8000/index
    #[Route('/index', name: 'app_index')]
    public function index(ArtRepository $artRepository): Response
{
    $arts = $artRepository->findAll();
    
    $artsByCategory = [];

    foreach ($arts as $art) {
        $category = $art->getCategories();
        $artsByCategory[$category][] = $art;
    }

    return $this->render('Pages/Main.html.twig', [
        'artsByCategory' => $artsByCategory,
    ]);
}
}
