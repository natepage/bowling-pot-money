<?php
declare(strict_types=1);

namespace App\Team\TeamInvite;

use App\Entity\Enum\TeamInviteStatusEnum;
use App\Entity\TeamInvite;
use App\Repository\TeamInviteRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final class TeamInviteSender
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly RouterInterface $router,
        private readonly TeamInviteRepository $teamInviteRepository
    ) {
    }

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function send(TeamInvite $teamInvite): void
    {
        $acceptInviteLink = $this->router->generate(
            'team_invite_accept',
            ['teamInviteId' => $teamInvite->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $email = (new TemplatedEmail())
            ->from(new Address('bowlingcokemoney@gmail.com', 'BowlingCokeMoney'))
            ->to($teamInvite->getEmail())
            ->subject('Team Invite')
            ->htmlTemplate('email/team_invite.html.twig')
            ->context([
                'acceptInviteLink' => $acceptInviteLink,
                'teamName' => $teamInvite->getTeam()->getTitle(),
            ]);

        $this->mailer->send($email);

        $teamInvite->setStatus(TeamInviteStatusEnum::EMAIL_SENT);

        $this->teamInviteRepository->save($teamInvite);
        $this->teamInviteRepository->flush();
    }
}