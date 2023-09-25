<?php

declare(strict_types=1);

namespace App\Controller\Web\Frontend\Team;

use App\Controller\Web\AbstractWebController;
use App\Entity\Enum\FinancialActivityTypeEnum;
use App\Financial\Dto\FinancialActivityCreateDto;
use App\Financial\FinancialActivityCreator;
use App\Form\AchievementAssignForm;
use App\Repository\AchievementRepository;
use App\Repository\GameRepository;
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
        private readonly AchievementRepository $achievementRepository,
        private readonly FinancialActivityCreator $financialActivityCreator,
        private readonly GameRepository $gameRepository,
        private readonly SessionRepository $sessionRepository,
    ) {
    }

    public function __invoke(Request $request, string $teamId, string $sessionId): Response
    {
        $session = $this->sessionRepository->findOneByIdAndTeamId($sessionId, $teamId);

        $form = $this
            ->createForm(AchievementAssignForm::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Form\Dto\AchievementAssignDto $data */
            $data = $form->getData();

            // TODO: move that to async message

            // TODO: ensure team member exists in given team

            // TODO: deal with achievement not found
            $achievement = $this->achievementRepository->find($data->getAchievementId());

            // TODO: deal with game not found
            $currentGame = $this->gameRepository->findOneUnfinishedBySessionIdAndTeamMemberId($sessionId, $data->getTeamMemberId());

            $financialActivityCreateDto = (new FinancialActivityCreateDto())
                ->setCreatedById($this->getCurrentUser()->getId())
                ->setGameId($currentGame->getId())
                ->setTeamId($teamId)
                ->setTeamMemberId($data->getTeamMemberId())
                ->setTitle($achievement->getTitle())
                ->setType(FinancialActivityTypeEnum::ACHIEVEMENT_ASSIGN->value)
                ->setSessionId($sessionId)
                ->setValue($achievement->getCost());

            $this->financialActivityCreator->createFinancialActivity($financialActivityCreateDto);

            return $this->redirectToRoute('teams_show_session', [
                'teamId' => $teamId,
                'sessionId' => $sessionId,
            ]);
        }

        return $this->render('web/team/achievement_assign.twig', [
            'session' => $session,
            'team' => $session->getTeam(),
            'form' => $form,
        ]);
    }
}
