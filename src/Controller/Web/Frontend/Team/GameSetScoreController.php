<?php
declare(strict_types=1);

namespace App\Controller\Web\Frontend\Team;

use App\Controller\Web\AbstractWebController;
use App\Form\GameSetScoreForm;
use App\Game\GameCreator;
use App\Game\GameManager;
use App\Repository\GameRepository;
use App\Repository\SessionRepository;
use App\Repository\TeamRepository;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/teams/{teamId}/sessions/{sessionId}/games/{gameId}/setScore',
    name: 'teams_game_set_score',
    methods: [Request::METHOD_GET, Request::METHOD_POST]
)]
final class GameSetScoreController extends AbstractWebController
{
    public function __construct(
        private readonly GameRepository $gameRepository,
        private readonly GameManager $gameManager,
        private readonly TeamRepository $teamRepository,
    ) {
    }

    public function __invoke(Request $request, string $teamId, string $sessionId, string $gameId): Response
    {
        $team = $this->teamRepository->find($teamId);
        $game = $this->gameRepository->find($gameId);

        $form = $this
            ->createForm(GameSetScoreForm::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Form\Dto\GameSetScoreDto $data */
            $data = $form->getData();

            try {
                $this->gameManager->setScore($game, $data->getScore());

                return $this->redirectToRoute('teams_show_session', [
                    'teamId' => $teamId,
                    'sessionId' => $sessionId,
                ]);
            } catch (\Throwable $throwable) {
                $form->addError(new FormError($throwable->getMessage()));
            }
        }

        return $this->render('web/team/game_set_score.html.twig', [
            'game' => $game,
            'form' => $form,
            'team' => $team,
        ]);
    }
}