<?php

declare(strict_types=1);

namespace App\Controller\Web\TurboFrame\Team;

use App\Controller\Web\TurboFrame\AbstractTurboFrameController;
use App\Repository\AchievementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/teams/{teamId}/sessions/{sessionId}/achievements/assign/achievements',
    name: '_frame_achievement_assign_achievement',
    methods: [Request::METHOD_GET]
)]
final class AchievementAssignAchievementsListController extends AbstractTurboFrameController
{
    public function __construct(
        private readonly AchievementRepository $achievementRepository,
    ) {
    }

    public function __invoke(string $teamId): Response
    {
        $achievements = $this->achievementRepository->findByTeamId($teamId);

        return $this->renderFrame('web/team/_includes/achievements_forAchievement_list.html.twig', [
            'achievements' => $achievements,
        ]);
    }
}
