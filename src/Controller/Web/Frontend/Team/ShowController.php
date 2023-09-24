<?php
declare(strict_types=1);

namespace App\Controller\Web\Frontend\Team;

use App\Controller\Web\AbstractWebController;
use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/teams/{teamId}', name: 'teams_show', methods: [Request::METHOD_GET])]
final class ShowController extends AbstractWebController
{
    public function __construct(
        private readonly TeamRepository $teamRepository,
    ) {
    }

    public function __invoke(string $teamId): Response
    {
        // TODO: deal with user not member of the team

        return $this->render('web/team/show.html.twig', [
            'team' => $this->teamRepository->find($teamId),
        ]);
    }
}
