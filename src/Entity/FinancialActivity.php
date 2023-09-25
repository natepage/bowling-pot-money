<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Contract\ActorAwareInterface;
use App\Entity\Enum\FinancialActivityTypeEnum;
use App\Entity\Mixin\ActorAwareTrait;
use App\Infrastructure\Doctrine\Dbal\Type\FinancialActivityTypeType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class FinancialActivity extends AbstractEntity  implements ActorAwareInterface
{
    use ActorAwareTrait;

    #[ORM\Column(type: Types::BIGINT)]
    private string $balance = '0';

    #[ORM\Column(type: Types::STRING)]
    private string $currency;

    #[ORM\ManyToOne(targetEntity: Game::class)]
    private ?Game $game = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $sequentialNumber = 0;

    #[ORM\ManyToOne(targetEntity: Session::class)]
    private ?Session $session = null;

    #[ORM\ManyToOne(targetEntity: Team::class)]
    private Team $team;

    #[ORM\ManyToOne(targetEntity: TeamMember::class)]
    private TeamMember $teamMember;

    #[ORM\Column(type: Types::STRING)]
    private string $title;

    #[ORM\Column(type: FinancialActivityTypeType::NAME)]
    private FinancialActivityTypeEnum $type = FinancialActivityTypeEnum::ACHIEVEMENT_ASSIGN;

    #[ORM\Column(type: Types::BIGINT)]
    private string $value;

    public function getBalance(): string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): FinancialActivity
    {
        $this->balance = $balance;
        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): FinancialActivity
    {
        $this->currency = $currency;
        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): FinancialActivity
    {
        $this->game = $game;
        return $this;
    }

    public function getSequentialNumber(): int
    {
        return $this->sequentialNumber;
    }

    public function setSequentialNumber(int $sequentialNumber): FinancialActivity
    {
        $this->sequentialNumber = $sequentialNumber;
        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): FinancialActivity
    {
        $this->session = $session;
        return $this;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): FinancialActivity
    {
        $this->team = $team;
        return $this;
    }

    public function getTeamMember(): TeamMember
    {
        return $this->teamMember;
    }

    public function setTeamMember(TeamMember $teamMember): FinancialActivity
    {
        $this->teamMember = $teamMember;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): FinancialActivity
    {
        $this->title = $title;
        return $this;
    }

    public function getType(): FinancialActivityTypeEnum
    {
        return $this->type;
    }

    public function setType(FinancialActivityTypeEnum $type): FinancialActivity
    {
        $this->type = $type;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): FinancialActivity
    {
        $this->value = $value;
        return $this;
    }

    protected function toString(): ?string
    {
        return $this->title;
    }
}