<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
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

    #[Route(path: '/admin', name: 'admin_index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}