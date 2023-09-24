<?php

declare(strict_types=1);

namespace App\Form\Dto;

final class SessionCreateDto
{
    /**
     * @var string[]
     */
    private array $memberIds = [];

    /**
     * @return string[]
     */
    public function getMemberIds(): array
    {
        return $this->memberIds;
    }

    /**
     * @param string[] $memberIds
     */
    public function setMemberIds(array $memberIds): SessionCreateDto
    {
        $this->memberIds = $memberIds;
        return $this;
    }
}