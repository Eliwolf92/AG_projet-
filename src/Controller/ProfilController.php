<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfilForm;
use App\Form\DeleteProfilForm;
use App\Form\EditPasswordForm;
use App\Repository\DemandesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class ProfilController extends AbstractController
{
    #[Route('/profil/{id}', name: 'app_profil')]
    public function profil( User $user, DemandesRepository $demandes): Response
    {   
        $demande = $demandes->findby(['demandeurs'=> $user]);

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'demandes' => $demande,
            'user' => $user,
            
        ]);
    }
    
    #[Route('/profil/settings/{id}', name: 'app_settings')]
    public function settings(User $user): Response
    {
        return $this->render('profil/settings.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profil/settings/{id}/edit', name: 'app_profil_change')]
    public function edit(User $user, Request $request, EntityManagerInterface $em,UserPasswordHasherInterface $passwordHasher): Response
    {

        $form = $this->createForm(EditProfilForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();

            if (!$passwordHasher->isPasswordValid($user, $password)) {
            $this->addFlash('erreur', 'L\'ancien mot de passe est incorrect.');
        } else {
            
        $em->flush();
        }

        return $this->redirectToRoute('app_profil', ['id' => $user->getId()]);
    }

        // logique pour modifier les infos
        return $this->render('profil/edit.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }

#[Route('/profil/settings/{id}/password', name: 'app_password_change')]
public function changePassword(User $user,Request $request,EntityManagerInterface $em,UserPasswordHasherInterface $passwordHasher): Response {
    $form = $this->createForm(EditPasswordForm::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $oldpassword = $form->get('oldpassword')->getData();
        $newpassword = $form->get('newpassword')->getData();

        if (!$passwordHasher->isPasswordValid($user, $oldpassword)) {
            $this->addFlash('erreur', 'L\'ancien mot de passe est incorrect.');
        } else {
            $hashedPassword = $passwordHasher->hashPassword($user, $newpassword);
            $user->setPassword($hashedPassword);

            $em->flush();

            $this->addFlash('success', 'Mot de passe mis à jour avec succès.');
            return $this->redirectToRoute('app_profil', ['id' => $user->getId()]);
        }
    }

    return $this->render('profil/password.html.twig', [
        'user' => $user,
        'form' => $form->createView(),
    ]);
}


#[Route('/profil/settings/{id}/delete', name: 'app_delete_profil')]
public function delete(User $user, EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $passwordHasher,TokenStorageInterface $tokenStorage,RequestStack $requestStack): Response
{
    $form = $this->createForm(DeleteProfilForm::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $oldpassword = $form->get('oldpassword')->getData();

        if (!$passwordHasher->isPasswordValid($user, $oldpassword)) {
            $this->addFlash('erreur', 'L\'ancien mot de passe est incorrect.');
        } else {

            $tokenStorage->setToken(null);
            $requestStack->getSession()->invalidate();

            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'Votre compte a bien été supprimé.');
            return $this->redirectToRoute('app_index');
        }
    }

    return $this->render('profil/delete_profil.html.twig', [
        'deleteForm' => $form->createView(),
        'user' => $user,
        'form' => $form
    ]);
}



}
