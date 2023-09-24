<?php

declare(strict_types=1);

namespace App\Controller\Web\Frontend;

use App\Controller\Web\AbstractWebController;
use App\Repository\TeamMemberRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/', name: 'web_index', methods: [Request::METHOD_GET])]
final class IndexController extends AbstractWebController
{
    public function __construct(
        private readonly TeamMemberRepository $teamMemberRepository,
    ) {
    }

    public function __invoke(): Response
    {
        $teamMembers = $this->teamMemberRepository->findByUserIdWithTeam(
            $this->getCurrentUser()->getId()
        );

        if (\count($teamMembers) === 1) {
            return $this->redirectToRoute('teams_show', [
                'teamId' => $teamMembers[0]->getTeam()->getId(),
            ]);
        }

        return $this->redirectToRoute('teams_list');
    }
}