<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
// https://127.0.0.1:8000/admin
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {

         return $this->redirectToRoute('admin_user_index');

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('AG Projet');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', 'App\Entity\User');
        yield MenuItem::linkToCrud('Art', 'fas fa-palette', 'App\Entity\Art');
        yield MenuItem::linkToLogout('Deconnexion', 'fas fa-deco', 'App\Entity\Index');
    }
}
