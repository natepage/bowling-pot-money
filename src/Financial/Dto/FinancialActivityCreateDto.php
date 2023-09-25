<?php

declare(strict_types=1);

namespace App\Financial\Dto;

final class FinancialActivityCreateDto
{
    private string $createdById;

    private ?string $gameId = null;

    private string $id;

    private ?string $sessionId = null;

    private string $teamId;

    private string $teamMemberId;

    private string $title;

    private string $type;

    private string $value;

    public function getCreatedById(): string
    {
        return $this->createdById;
    }

    public function setCreatedById(string $createdById): FinancialActivityCreateDto
    {
        $this->createdById = $createdById;
        return $this;
    }

    public function getGameId(): ?string
    {
        return $this->gameId;
    }

    public function setGameId(?string $gameId): FinancialActivityCreateDto
    {
        $this->gameId = $gameId;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): FinancialActivityCreateDto
    {
        $this->id = $id;
        return $this;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(?string $sessionId): FinancialActivityCreateDto
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    public function getTeamId(): string
    {
        return $this->teamId;
    }

    public function setTeamId(string $teamId): FinancialActivityCreateDto
    {
        $this->teamId = $teamId;
        return $this;
    }

    public function getTeamMemberId(): string
    {
        return $this->teamMemberId;
    }

    public function setTeamMemberId(string $teamMemberId): FinancialActivityCreateDto
    {
        $this->teamMemberId = $teamMemberId;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): FinancialActivityCreateDto
    {
        $this->title = $title;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): FinancialActivityCreateDto
    {
        $this->type = $type;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): FinancialActivityCreateDto
    {
        $this->value = $value;
        return $this;
    }
}
