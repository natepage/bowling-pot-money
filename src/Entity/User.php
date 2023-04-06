<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'app_user')]
#[ORM\UniqueConstraint(columns: ['email'])]
class User extends AbstractEntity implements UserInterface
{
    #[ORM\Column(type: Types::STRING)]
    private string $email;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $emailVerified = false;

    #[ORM\Column(type: Types::STRING)]
    private string $locale;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::STRING)]
    private ?string $picture = null;

    #[ORM\Column(type: Types::STRING)]
    private string $sub;

    public static function create(array $params): self
    {
        return (new self())
            ->setEmail($params['email'])
            ->setEmailVerified($params['email_verified'])
            ->setLocale($params['locale'] ?? 'en')
            ->setName($params['name'])
            ->setPicture($params['picture'] ?? null)
            ->setSub($params['sub']);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function isEmailVerified(): bool
    {
        return $this->emailVerified;
    }

    public function setEmailVerified(bool $emailVerified): User
    {
        $this->emailVerified = $emailVerified;
        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): User
    {
        $this->locale = $locale;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): User
    {
        $this->picture = $picture;
        return $this;
    }

    public function getSub(): string
    {
        return $this->sub;
    }

    public function setSub(string $sub): User
    {
        $this->sub = $sub;
        return $this;
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
        return $this->sub;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->getEmail(),
            'email_verified' => $this->isEmailVerified(),
            'locale' => $this->getLocale(),
            'name' => $this->getName(),
            'picture' => $this->getPicture(),
            'sub' => $this->getSub(),
        ];
    }

    public function updateFromArray(array $params): self
    {
        return $this
            ->setEmail($params['email'])
            ->setEmailVerified($params['email_verified'])
            ->setLocale($params['locale'] ?? 'en')
            ->setName($params['name'])
            ->setPicture($params['picture'] ?? null)
            ->setSub($params['sub']);
    }

    protected function toString(): ?string
    {
        return $this->getName() ?? $this->getUserIdentifier();
    }
}