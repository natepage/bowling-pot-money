<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class Team extends AbstractEntity
{
    #[ORM\Column(type: Types::STRING)]
    private ?string $currency = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $title = null;

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): Team
    {
        $this->currency = $currency;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Team
    {
        $this->title = $title;
        return $this;
    }
}