<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20230407034103 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('ALTER TABLE team_invite ALTER access_level TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE team_invite ALTER status TYPE VARCHAR(255)');
        $this->addSql('CREATE INDEX team_invite_email_team_idx ON team_invite (email, team_id)');
        $this->addSql('ALTER TABLE team_member ADD balance BIGINT NOT NULL');
        $this->addSql('ALTER TABLE team_member ADD currency VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE team_member ALTER access_level TYPE VARCHAR(255)');
    }

    public function rollback(): void
    {
        $this->addSql('ALTER TABLE team_member DROP balance');
        $this->addSql('ALTER TABLE team_member DROP currency');
        $this->addSql('ALTER TABLE team_member ALTER access_level TYPE VARCHAR(255)');
        $this->addSql('DROP INDEX team_invite_email_team_idx');
        $this->addSql('ALTER TABLE team_invite ALTER access_level TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE team_invite ALTER status TYPE VARCHAR(255)');
    }
}
