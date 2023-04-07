<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20230407001035 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('CREATE TABLE team_member (id UUID NOT NULL, team_id UUID DEFAULT NULL, user_id UUID DEFAULT NULL, access_level VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6FFBDA1296CD8AE ON team_member (team_id)');
        $this->addSql('CREATE INDEX IDX_6FFBDA1A76ED395 ON team_member (user_id)');
        $this->addSql('CREATE UNIQUE INDEX team_member_unique ON team_member (team_id, user_id)');
        $this->addSql('COMMENT ON COLUMN team_member.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN team_member.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE team_member ADD CONSTRAINT FK_6FFBDA1296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_member ADD CONSTRAINT FK_6FFBDA1A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function rollback(): void
    {
        $this->addSql('ALTER TABLE team_member DROP CONSTRAINT FK_6FFBDA1296CD8AE');
        $this->addSql('ALTER TABLE team_member DROP CONSTRAINT FK_6FFBDA1A76ED395');
        $this->addSql('DROP TABLE team_member');
    }
}
