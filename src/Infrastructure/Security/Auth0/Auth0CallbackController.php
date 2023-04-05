<?php
declare(strict_types=1);

namespace App\Infrastructure\Security\Auth0;

use App\Infrastructure\Helper\UrlHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/auth0/callback', name: 'admin_auth0_callback', methods: ['GET'])]
final class Auth0CallbackController extends AbstractController
{
    public function __invoke(Request $request): RedirectResponse
    {
        return $request->query->has('redirectAfterLogin')
            ? $this->redirect(UrlHelper::urlSafeBase64Decode($request->query->get('redirectAfterLogin')))
            : $this->redirectToRoute('admin_index');
    }
}