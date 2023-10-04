<?php

namespace App\Controller\Admin;

use App\Entity\CarteTux;
use App\Entity\ClasseurTux;
use App\Entity\MembreTux;
use App\Entity\VitrineTux;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(ClasseurTuxCrudController::class)->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CollectionTux Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Classeurs Tux','fas fa-list', ClasseurTux::class);
        yield MenuItem::linkToCrud('Cartes Tux', 'fas fa-list', CarteTux::class);
        yield MenuItem::linkToCrud('Membres Tux', 'fas fa-list', MembreTux::class);
        yield MenuItem::linkToCrud('Vitrines Tux', 'fas fa-list', VitrineTux::class);
    }
}
