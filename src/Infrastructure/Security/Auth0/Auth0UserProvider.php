<?php
declare(strict_types=1);

namespace App\Infrastructure\Security\Auth0;

use App\Entity\User;
use App\Repository\UserRepository;
use RuntimeException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class Auth0UserProvider implements UserProviderInterface
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        throw new RuntimeException(\sprintf('%s not implemented', __FUNCTION__));
    }

    public function refreshUser(UserInterface|Auth0User $user): UserInterface
    {
        $expiry = $user->getExpiry();
        if ($expiry === null || ((int)($expiry) < \time())) {
            throw new UserNotFoundException('User token has expired');
        }

        // Create db user if first time
        $dbUser = $this->userRepository->findOneByEmail($user->getEmail());
        if ($dbUser === null) {
            $dbUser = User::create($user->toArray());

            $this->userRepository->save($dbUser);
            $this->userRepository->flush();
        }

        // Update db user if auth0 details updated
        if ($this->areIdentical($user, $dbUser) === false) {
            $this->userRepository->save($dbUser->updateFromArray($user->toArray()));
            $this->userRepository->flush();
        }

        return $user->setDbUser($dbUser);
    }

    public function supportsClass(string $class): bool
    {
        return $class === Auth0User::class;
    }

    private function areIdentical(Auth0User $auth0User, User $dbUser): bool
    {
        $auth0UserArray = $auth0User->toArray();

        foreach ($dbUser->toArray() as $name => $value) {
            if (isset($auth0UserArray[$name]) && $auth0UserArray[$name] !== $value) {
                return false;
            }
        }

        return true;
    }
}