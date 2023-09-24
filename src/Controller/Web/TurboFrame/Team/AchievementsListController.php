<?php

declare(strict_types=1);

namespace App\Controller\Web\TurboFrame\Team;

use App\Controller\Web\TurboFrame\AbstractTurboFrameController;
use App\Repository\AchievementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/teams/{teamId}/achievements', name: '_frame_achievements_list', methods: [Request::METHOD_GET])]
final class AchievementsListController extends AbstractTurboFrameController
{
    public function __construct(
        private readonly AchievementRepository $achievementRepository,
    ) {
    }

    public function __invoke(string $teamId): Response
    {
        $achievements = $this->achievementRepository->findByTeamId($teamId);

        return $this->renderFrame('web/team/_includes/achievements_list.html.twig', [
            'achievements' => $achievements,
        ]);
    }
}
