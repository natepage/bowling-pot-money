<?php

declare(strict_types=1);

namespace App\Controller\Web\Frontend\Team;

use App\Controller\Web\AbstractWebController;
use App\Entity\Achievement;
use App\Form\AchievementForm;
use App\Repository\AchievementRepository;
use App\Repository\TeamRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AchievementFormsController extends AbstractWebController
{
    public function __construct(
        private readonly AchievementRepository $achievementRepository,
        private readonly TeamRepository $teamRepository,
    ) {
    }

    #[Route(
        path: '/teams/{teamId}/achievements/new',
        name: 'teams_create_achievement',
        methods: [Request::METHOD_GET, Request::METHOD_POST]
    )]
    public function new(Request $request, string $teamId): Response
    {
        //TODO: handle team not found
        $team = $this->teamRepository->find($teamId);
        $achievement = (new Achievement())->setTeam($team);

        $form = $this->createAchievementForm($request, $achievement);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\Achievement $achievement */
            $achievement = $form->getData();

            $this->achievementRepository->save($achievement);
            $this->achievementRepository->flush();

            return $this->redirectToRoute('teams_show', ['teamId' => $teamId]);
        }

        return $this->render('web/team/achievement_form.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route(
        path: '/teams/{teamId}/achievements/{achievementId}/update',
        name: 'teams_update_achievement',
        methods: [Request::METHOD_GET, Request::METHOD_POST]
    )]
    public function update(Request $request, string $teamId, string $achievementId): Response
    {
        $achievement = $this->achievementRepository->findOneByIdAndTeamId($achievementId, $teamId);

        $form = $this->createAchievementForm($request, $achievement);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\Achievement $achievement */
            $achievement = $form->getData();

            $this->achievementRepository->save($achievement);
            $this->achievementRepository->flush();

            return $this->redirectToRoute('teams_show', ['teamId' => $teamId]);
        }

        return $this->render('web/team/achievement_form.twig', [
            'achievement' => $achievement,
            'team' => $achievement->getTeam(),
            'form' => $form,
        ]);
    }

    private function createAchievementForm(Request $request, Achievement $achievement): FormInterface
    {
        return $this
            ->createForm(AchievementForm::class, $achievement)
            ->handleRequest($request);
    }
}