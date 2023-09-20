<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Achievement;
use App\Entity\Session;
use App\Entity\Team;
use App\Entity\TeamInvite;
use App\Entity\TeamMember;
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

        yield MenuItem::section('Teams');
        yield MenuItem::linkToCrud('List', 'fa fa-list', Team::class);
        yield MenuItem::linkToCrud('Members', 'fa fa-people-group', TeamMember::class);
        yield MenuItem::linkToCrud('Invites', 'fa fa-send', TeamInvite::class);
        yield MenuItem::linkToCrud('Achievements', 'fa fa-money', Achievement::class);
        yield MenuItem::linkToCrud('Sessions', 'fa fa-bowling-ball-pin', Session::class);

        yield MenuItem::section('Core');
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
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