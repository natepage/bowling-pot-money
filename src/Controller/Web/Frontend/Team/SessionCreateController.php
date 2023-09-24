<?php
declare(strict_types=1);

namespace App\Controller\Web\Frontend\Team;

use App\Controller\Web\AbstractWebController;
use App\Form\SessionCreateForm;
use App\Repository\TeamRepository;
use App\Session\SessionManager;
use App\Session\SessionMemberManager;
use EonX\EasyErrorHandler\Interfaces\ErrorHandlerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/teams/{teamId}/sessions/new',
    name: 'teams_create_session',
    methods: [Request::METHOD_GET, Request::METHOD_POST]
)]
final class SessionCreateController extends AbstractWebController
{
    public function __construct(
        private readonly TeamRepository $teamRepository,
        private readonly SessionManager $sessionManager,
        private readonly SessionMemberManager $sessionMemberManager,
        private readonly ErrorHandlerInterface $errorHandler,
    ) {
    }

    public function __invoke(Request $request, string $teamId): Response
    {
        $team = $this->teamRepository->find($teamId);

        $form = $this
            ->createForm(SessionCreateForm::class, options: ['teamId' => $teamId])
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Form\Dto\SessionCreateDto $data */
            $data = $form->getData();

            try {
                $session = $this->sessionManager->openSession($team);

                $this->sessionMemberManager->addMembersByIds($session, $data->getMemberIds());

                return $this->redirectToRoute('teams_show', [
                    'teamId' => $teamId,
                ]);
            } catch (\Throwable $throwable) {
                $this->errorHandler->report($throwable);

                $form->addError(new FormError($throwable->getMessage()));
            }
        }

        return $this->render('web/team/session_create.html.twig', [
            'form' => $form,
            'team' => $team,
        ]);
    }
}