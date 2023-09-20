<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\SessionStatusEnum;
use App\Infrastructure\Doctrine\Dbal\Type\SessionStatusType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Index(columns: ['team_id', 'status'])]
class Session extends AbstractEntity
{
    public const MIN_MEMBERS = 1;

    public const MAX_MEMBERS = 10;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'members')]
    private Team $team;

    #[ORM\Column(type: SessionStatusType::NAME)]
    private SessionStatusEnum $status = SessionStatusEnum::OPENED;

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): Session
    {
        $this->team = $team;
        return $this;
    }

    public function getStatus(): SessionStatusEnum
    {
        return $this->status;
    }

    public function setStatus(SessionStatusEnum $status): Session
    {
        $this->status = $status;
        return $this;
    }

    protected function toString(): ?string
    {
        return $this->getCreatedAt()?->format('d/m/Y');
    }
}