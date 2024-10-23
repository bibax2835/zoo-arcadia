<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Entity\Animal;
use App\Entity\Comment;
use App\Entity\Habitat;
use App\Entity\Service;
use App\Entity\VeterinaryReport;
use App\Entity\Zoo;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Zoo Arcadia');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
            MenuItem::linkToCrud('Animals', 'fa fa-paw', Animal::class),
            MenuItem::linkToCrud('Comments', 'fa fa-comments', Comment::class),
            MenuItem::linkToCrud('Habitats', 'fa fa-tree', Habitat::class),
            MenuItem::linkToCrud('Services', 'fa fa-concierge-bell', Service::class),
            MenuItem::linkToCrud('Veterinary Reports', 'fa fa-file-medical', VeterinaryReport::class),
            MenuItem::linkToCrud('Zoo', 'fa fa-building', Zoo::class),
        ];
    }
}
