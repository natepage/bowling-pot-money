<?php
declare(strict_types=1);

namespace App\Controller\Api\Session\SessionMember;

use App\Repository\SessionRepository;
use App\Session\SessionMemberManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sessions/{sessionId}/members/add', name: 'session_member_add', methods: ['POST'])]
final class AddSessionMembersController extends AbstractController
{
    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly SessionMemberManager $sessionMemberManager
    ) {
    }

    public function __invoke(Request $request, string $sessionId): RedirectResponse
    {
        // TODO: Deal with not found session
        $session = $this->sessionRepository->find($sessionId);

        /** @var string[] $teamMemberIds */
        $teamMemberIds = $request->toArray()['teamMemberIds'] ?? [];

        $this->sessionMemberManager->addMembersByIds($session, $teamMemberIds);

        // TODO: redirect to better page for facing users
        return $this->redirectToRoute('admin_index');
    }
}