<?php

declare(strict_types=1);

namespace App\Controller\Web\Frontend\Team;

use App\Controller\Web\AbstractWebController;
use App\Form\AchievementAssignForm;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/teams/{teamId}/sessions/{sessionId}/achievements/assign',
    name: 'teams_assign_achievement',
    methods: [Request::METHOD_GET, Request::METHOD_POST]
)]
final class AchievementAssignController extends AbstractWebController
{
    public function __construct(
        private readonly SessionRepository $sessionRepository,
    ) {
    }

    public function __invoke(Request $request, string $teamId, string $sessionId): Response
    {
        $session = $this->sessionRepository->findOneByIdAndTeamId($sessionId, $teamId);

        $form = $this
            ->createForm(AchievementAssignForm::class)
            ->handleRequest($request);

        return $this->render('web/team/achievement_assign.twig', [
            'session' => $session,
            'team' => $session->getTeam(),
            'form' => $form,
        ]);
    }
}
