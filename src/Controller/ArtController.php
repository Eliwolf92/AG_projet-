<?php

namespace App\Controller;

use App\Entity\Art;
use App\Form\ArtForm;
use App\Form\AddArtForm;
use App\Form\EditArtForm;
use App\Repository\ArtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/art')]
final class ArtController extends AbstractController
{
    #[Route(name: 'app_art_index', methods: ['GET'])]
    public function index(ArtRepository $artRepository): Response
    {
        return $this->render('art/index.html.twig', [
            'art' => $artRepository->findAll(),
        ]);
    }

    #[Route('/artiste/new', name: 'art_add')]
    public function add(Request $request, EntityManagerInterface $em, Security $security,)
    {
        $this->denyAccessUnlessGranted('ROLE_ARTISTE');

        $art = new Art();
        $form = $this->createForm(AddArtForm::class, $art);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $security->getUser();
            $art->setArtiste($user);

            $em->persist($art);
            $em->flush();

            return $this->redirectToRoute('app_index'); // ou une autre route après ajout
        }

        $user = $security->getUser();

        return $this->render('art/add.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }


    #[Route('/artiste/edit/{id}', name: 'art_edit')]
    public function edit(Art $art, Request $request, EntityManagerInterface $em, Security $security) : Response{
         $this->denyAccessUnlessGranted('ROLE_ARTISTE');

          // Sécurité : l'utilisateur ne peut modifier QUE ses œuvres
    $user = $security->getUser();
    if ($art->getArtiste() !== $user) {
        throw $this->createAccessDeniedException('Vous ne pouvez modifier que vos propres œuvres.');
    }

    $form = $this->createForm(EditArtForm::class, $art);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();

        return $this->redirectToRoute('app_index'); // ou autre route
    }

    return $this->render('art/edit.html.twig', [
        'form' => $form->createView(),
        'art' => $art,
        'user' => $user
    ]);
    }

    
}
