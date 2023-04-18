<?php
declare(strict_types=1);

namespace App\Entity\Mixin;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

trait ActorAwareTrait
{
    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $updatedBy = null;

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setCreatedBy(User $user): self
    {
        $this->createdBy = $user;
        return $this;
    }

    public function setUpdatedBy(User $user): self
    {
        $this->updatedBy = $user;
        return $this;
    }
}