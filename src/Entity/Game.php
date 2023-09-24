<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\GameStatusEnum;
use App\Infrastructure\Doctrine\Dbal\Type\GameStatusType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Game extends AbstractEntity
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $score = null;

    #[ORM\ManyToOne(targetEntity: Session::class)]
    private Session $session;

    #[ORM\Column(type: GameStatusType::NAME)]
    private GameStatusEnum $status = GameStatusEnum::OPENED;

    #[ORM\ManyToOne(targetEntity: TeamMember::class)]
    private TeamMember $teamMember;

    public function isOpened(): bool
    {
        return $this->status === GameStatusEnum::OPENED;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): Game
    {
        $this->score = $score;
        return $this;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function setSession(Session $session): Game
    {
        $this->session = $session;
        return $this;
    }

    public function getStatus(): GameStatusEnum
    {
        return $this->status;
    }

    public function setStatus(GameStatusEnum $status): Game
    {
        $this->status = $status;
        return $this;
    }

    public function getTeamMember(): TeamMember
    {
        return $this->teamMember;
    }

    public function setTeamMember(TeamMember $teamMember): Game
    {
        $this->teamMember = $teamMember;
        return $this;
    }

    protected function toString(): ?string
    {
        return null;
    }
}