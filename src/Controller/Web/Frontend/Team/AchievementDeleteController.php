<?php

declare(strict_types=1);

namespace App\Controller\Web\Frontend\Team;

use App\Controller\Web\AbstractWebController;
use App\Form\AchievementDeleteForm;
use App\Repository\AchievementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/teams/{teamId}/achievements/{achievementId}/delete',
    name: 'teams_delete_achievement',
    methods: [Request::METHOD_GET, Request::METHOD_POST]
)]
final class AchievementDeleteController extends AbstractWebController
{
    public function __construct(
        private readonly AchievementRepository $achievementRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(Request $request, string $teamId, string $achievementId): Response
    {
        // TODO: handle achievement not found
        $achievement = $this->achievementRepository->findOneByIdAndTeamId($achievementId, $teamId);

        $form = $this
            ->createForm(AchievementDeleteForm::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // TODO: use repository when eonx-com/easy-repository fixed
            $this->entityManager->remove($achievement);
            $this->entityManager->flush();

            $this->addFlash('success', \sprintf('Deleted achievement "%s"', $achievement->getTitle()));

            return $this->redirectToRoute('teams_show', ['teamId' => $teamId]);
        }

        return $this->render('web/team/achievement_delete.html.twig', [
            'achievement' => $achievement,
            'team' => $achievement->getTeam(),
            'form' => $form,
        ]);
    }
}