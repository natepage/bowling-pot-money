<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Entity\Achievement;
use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DashboardController extends AbstractDashboardController
{
    public function configureDashboard(): Dashboard
    {
        $dashboard = parent::configureDashboard();
        $dashboard
            ->setTitle('Bowling Coke Money')
            ->renderContentMaximized();

        return $dashboard;
    }

    public function configureMenuItems(): iterable
    {
        yield from parent::configureMenuItems();

        yield MenuItem::linkToCrud('Teams', 'fa fa-people-group', Team::class);
        yield MenuItem::linkToCrud('Achievements', 'fa fa-people-group', Achievement::class);
    }

    #[Route(path: '/admin', name: 'admin_index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}