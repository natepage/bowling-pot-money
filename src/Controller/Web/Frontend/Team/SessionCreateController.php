<?php
declare(strict_types=1);

namespace App\Controller\Web\Frontend\Team;

use App\Controller\Web\AbstractWebController;
use App\Form\CreateSessionForm;
use App\Repository\TeamRepository;
use App\Session\SessionManager;
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
        private readonly ErrorHandlerInterface $errorHandler,
    ) {
    }

    public function __invoke(Request $request, string $teamId): Response
    {
        $team = $this->teamRepository->find($teamId);

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
                $this->errorHandler->report($throwable);

                $form->addError(new FormError('Not implemented yet'));
            }
        }

        return $this->render('web/team/session_create.html.twig', [
            'form' => $form,
            'team' => $team,
        ]);
    }
}