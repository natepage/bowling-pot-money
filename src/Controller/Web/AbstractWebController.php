<?php
declare(strict_types=1);

namespace App\Controller\Web;

use App\Common\Traits\DealsWithSecurity;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractWebController extends AbstractController
{
    use DealsWithSecurity;

    private Security $security;

    #[Required]
    public function setSecurity(Security $security): void
    {
        $this->security = $security;
    }

    /**
     * @param \App\Entity\TeamMember[] $teamMembers
     */
    protected function canAccessTeam(array $teamMembers): bool
    {
        $user = $this->getCurrentUser();

        foreach ($teamMembers as $teamMember) {
            if ($teamMember->getUser()->getId() === $user->getId()) {
                return true;
            }
        }

        return false;
    }

    protected function getCurrentUser(): User
    {
        // TODO: Throw exception if user null as it should never be
        return $this->getDbUser($this->security);
    }
}
