<?php

namespace App\Controller;

use App\Entity\Art;
use App\Entity\Demandes;
use App\Form\RequestForm;
use App\Repository\ArtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class IndexController extends AbstractController
{   
    //https://127.0.0.1:8000/accueil
    #[Route('/accueil', name: 'app_index')]
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

    #[Route('/a_propos', name:'app_annexe')]
    public function annex():Response{
        return $this->render('Pages/Annexe.html.twig');
    }

    #[Route('/index/art_show/{id}', name: 'app_art_show')]
    public function art_show(int $id ,ArtRepository $artRepository): Response
{
         $art = $artRepository->find($id);

             if (!$art) {
        throw $this->createNotFoundException('Œuvre non trouvée.');
    }

         return $this->render('Pages/ArtShow.html.twig', [
            'art' => $art,
         ]);


}

#[Route('/contact/oeuvre/{id}', name: 'app_contact')]
public function contact(int $id,Request $request,EntityManagerInterface $em
): Response 
    {
    $art = $em->getRepository(Art::class)->find($id);

    if (!$art) {
        throw $this->createNotFoundException("Œuvre non trouvée.");
    }

    $artiste = $art->getArtiste(); // Ce champ doit être une relation ManyToOne vers User
    if (!$artiste) {
        throw $this->createNotFoundException("Artiste non associé à cette œuvre.");
    }

    $demande = new Demandes();
    $demande->setDemandeurs($this->getUser());
    $demande->setArtiste($artiste);

    $form = $this->createForm(RequestForm::class, $demande);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($demande);
        $em->flush();

        $this->addFlash('success', 'Votre message a bien été envoyé.');
        return $this->redirectToRoute('app_index');
    }

    return $this->render('Pages/Contact.html.twig', [
        'requestForm' => $form->createView(),
        'artiste' => $artiste,
        'oeuvre' => $art
    ]);
}
}
