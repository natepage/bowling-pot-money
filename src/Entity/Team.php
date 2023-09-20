<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Contract\ActorAwareInterface;
use App\Entity\Mixin\ActorAwareTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Team extends AbstractEntity implements ActorAwareInterface
{
    public const MAX_MEMBERS = 10;

    use ActorAwareTrait;

    #[ORM\Column(type: Types::STRING)]
    private string $currency;

    #[ORM\Column(type: Types::STRING)]
    private string $title;

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): Team
    {
        $this->currency = $currency;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Team
    {
        $this->title = $title;
        return $this;
    }

    protected function toString(): ?string
    {
        return $this->title ?? null;
    }
}