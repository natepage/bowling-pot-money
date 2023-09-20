<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ['session_id', 'team_member_id'])]
class SessionMember extends AbstractEntity
{
    #[ORM\ManyToOne(targetEntity: Session::class)]
    private Session $session;

    #[ORM\ManyToOne(targetEntity: TeamMember::class)]
    private TeamMember $teamMember;

    public function getSession(): Session
    {
        return $this->session;
    }

    public function setSession(Session $session): SessionMember
    {
        $this->session = $session;
        return $this;
    }

    public function getTeamMember(): TeamMember
    {
        return $this->teamMember;
    }

    public function setTeamMember(TeamMember $teamMember): SessionMember
    {
        $this->teamMember = $teamMember;
        return $this;
    }

    protected function toString(): ?string
    {
        return null;
    }
}