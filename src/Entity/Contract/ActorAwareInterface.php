<?php
declare(strict_types=1);

namespace App\Entity\Contract;

use App\Entity\User;

interface ActorAwareInterface
{
    public function getCreatedBy(): ?User;

    public function getUpdatedBy(): ?User;

    public function setCreatedBy(User $user): self;

    public function setUpdatedBy(User $user): self;
}