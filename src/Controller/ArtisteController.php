<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Demandes;
use App\Repository\ArtRepository;
use App\Repository\DemandesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/artiste/{id}/demandes', name:'app_artiste_demande')]
    public function demandesReçues(User $user,DemandesRepository $demandesRepository
): Response {
    // Vérifie qu'on regarde son propre profil
    if ($this->getUser() !== $user) {
        throw $this->createAccessDeniedException();
    }

    // On récupère les demandes reçues par cet artiste
    $demandes = $demandesRepository->findBy(['artiste' => $user]);

    return $this->render('artiste/demandes.html.twig', [
        'demandes' => $demandes,
        'user' => $user
    ]);
}

    #[Route('/demande/{id}/repondre', name: 'demande_repondre')]
        public function repondre(Request $request,Demandes $demande,EntityManagerInterface $em
        ): Response {
            if ($this->getUser() !== $demande->getArtiste()) {
                throw $this->createAccessDeniedException();
            }

            $form = $this->createForm(\App\Form\ReponseFormType::class, $demande);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                $this->addFlash('success', 'Votre réponse a bien été enregistrée.');
                return $this->redirectToRoute('app_artiste_demande', ['id' => $this->getUser()->getUserIdentifier()]);
            }

            return $this->render('artiste/Reponse.html.twig', [
                'form' => $form->createView(),
                'demande' => $demande
            ]);
        }





    
}
