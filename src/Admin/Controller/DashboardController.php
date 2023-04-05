<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Entity\Achievement;
use App\Entity\Team;
use App\Entity\User;
use App\Infrastructure\Security\Auth0\Auth0User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
        yield MenuItem::linkToCrud('Users', 'fa fa-people-group', User::class);
    }

    public function configureUserMenu(UserInterface|Auth0User $user): UserMenu
    {
        $userMenu = parent::configureUserMenu($user);
        $userMenu
            ->setAvatarUrl($user->getDbUser()->getPicture())
            ->setName($user->getDbUser()->getName());

        return $userMenu;
    }

    #[Route(path: '/admin', name: 'admin_index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}