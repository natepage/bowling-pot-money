<?php
declare(strict_types=1);

namespace App\Controller\Web\Team;

use App\Controller\Web\AbstractWebController;
use App\Form\CreateSessionForm;
use App\Form\CreateTeamInviteForm;
use App\Form\Dto\CreateTeamInviteDto;
use App\Repository\TeamMemberRepository;
use App\Repository\TeamRepository;
use App\Session\SessionManager;
use App\Team\TeamInvite\TeamInviteFactory;
use App\Team\TeamInvite\TeamInvitePersister;
use App\Team\TeamInvite\TeamInviteSender;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/teams/{teamId}/teamInvites/new', name: 'teams_create_team_invite', methods: ['GET', 'POST'])]
final class CreateTeamInviteController extends AbstractWebController
{
    public function __construct(
        private readonly TeamInviteFactory $teamInviteFactory,
        private readonly TeamInvitePersister $teamInvitePersister,
        private readonly TeamInviteSender $teamInviteSender,
        private readonly TeamRepository $teamRepository,
    ) {
    }

    protected function doInvoke(Request $request): Response
    {
        $teamId = $request->attributes->get('teamId');
        $team = $this->teamRepository->find($teamId);

        $form = $this
            ->createForm(CreateTeamInviteForm::class, new CreateTeamInviteDto())
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamInvite = $this->teamInviteFactory->create(
                $team,
                $form->getData()->getEmail(),
                $form->getData()->getAccessLevel(),
                $form->getData()->getExpiresAt()
            );

            $this->teamInvitePersister->persist($teamInvite);
            $this->teamInviteSender->send($teamInvite);

            return $this->redirectToRoute('teams_show', [
                'teamId' => $team->getId(),
            ]);
        }

        return $this->render('web/turboFrame/team/team_invite_create.html.twig', [
            'form' => $form,
            'team' => $team,
        ]);
    }
}