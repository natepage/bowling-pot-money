<?php
declare(strict_types=1);

namespace App\Infrastructure\Security\Auth0;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class Auth0User implements UserInterface
{
    private ?User $dbUser = null;

    public function __construct(private readonly array $data)
    {
    }

    public function setDbUser(?User $dbUser): self
    {
        $this->dbUser = $dbUser;
        return $this;
    }

    public function getDbUser(): ?User
    {
        return $this->dbUser;
    }

    public function getEmail(): string
    {
        return $this->data['email'];
    }

    public function getExpiry(): ?int
    {
        return $this->data['exp'] ?? null;
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getPicture(): ?string
    {
        return $this->data['picture'];
    }

    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return ['ROLE_ADMIN'];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->data['sub'];
    }
}