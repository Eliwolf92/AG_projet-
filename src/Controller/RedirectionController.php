<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

class RedirectionController extends AbstractController
{
#[Route('/redirect-after-login', name: 'app_redirect_after_login')]
public function redirectAfterLogin(): RedirectResponse
{
    /** @var \App\Entity\User $user */
    $user = $this->getUser();

    if ($this->isGranted('ROLE_ADMIN')) {
        return $this->redirectToRoute('admin');
    }

    if ($this->isGranted('ROLE_ARTISTE')) {
        return $this->redirectToRoute('app_artiste_page', ['id' => $user->getId()]);
    }

    return $this->redirectToRoute('app_profil');
}
}
