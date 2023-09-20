<?php
declare(strict_types=1);

namespace App\Controller\Web\Team;

use App\Controller\Web\AbstractWebController;
use App\Form\CreateSessionForm;
use App\Repository\TeamMemberRepository;
use App\Session\SessionManager;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/teams/{teamId}/sessions/new', name: 'teams_create_session', methods: ['GET', 'POST'])]
final class CreateSessionController extends AbstractWebController
{
    public function __construct(
        private readonly TeamMemberRepository $teamMemberRepository,
        private readonly SessionManager $sessionManager
    ) {
    }

    protected function doInvoke(Request $request): Response
    {
        $teamId = $request->attributes->get('teamId');
        $teamMembers = $this->teamMemberRepository->findByTeamIdWithTeamAndUser($teamId);
        $team = \current($teamMembers)->getTeam();

        $form = $this
            ->createForm(CreateSessionForm::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->sessionManager->openSession($team);

                return $this->redirectToRoute('teams_show', [
                    'teamId' => $teamId,
                ]);
            } catch (\Throwable $throwable) {
                $form->addError(new FormError('Not implemented yet'));
            }
        }

        return $this->render('web/turboFrame/team/session_create.html.twig', [
            'form' => $form,
            'team' => $team,
        ]);
    }
}