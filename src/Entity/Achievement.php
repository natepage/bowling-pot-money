<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Achievement extends AbstractEntity
{
    #[ORM\Column(type: Types::BIGINT)]
    private string $cost;

    #[ORM\Column(type: Types::STRING)]
    private string $currency;

    #[ORM\Column(type: Types::STRING)]
    private string $title;

    #[ORM\ManyToOne(targetEntity: Team::class)]
    private Team $team;

    public function getCost(): string
    {
        return $this->cost;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCost(string $cost): Achievement
    {
        $this->cost = $cost;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Achievement
    {
        $this->title = $title;
        return $this;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): Achievement
    {
        $this->currency = $team->getCurrency();
        $this->team = $team;

        return $this;
    }

    protected function toString(): ?string
    {
        return $this->title ?? null;
    }
}