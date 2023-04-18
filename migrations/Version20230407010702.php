<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20230407010702 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('CREATE TABLE team_invite (id UUID NOT NULL, team_id UUID DEFAULT NULL, access_level VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B1F9570E296CD8AE ON team_invite (team_id)');
        $this->addSql('COMMENT ON COLUMN team_invite.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN team_invite.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN team_invite.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE team_invite ADD CONSTRAINT FK_B1F9570E296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_member ALTER access_level TYPE VARCHAR(255)');
    }

    public function rollback(): void
    {
        $this->addSql('ALTER TABLE team_invite DROP CONSTRAINT FK_B1F9570E296CD8AE');
        $this->addSql('DROP TABLE team_invite');
        $this->addSql('ALTER TABLE team_member ALTER access_level TYPE VARCHAR(255)');
    }
}
