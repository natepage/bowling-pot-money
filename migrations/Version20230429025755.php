<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20230429025755 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('CREATE TABLE session (id UUID NOT NULL, team_id UUID DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D044D5D4296CD8AE ON session (team_id)');
        $this->addSql('CREATE INDEX IDX_D044D5D4296CD8AE7B00651C ON session (team_id, status)');
        $this->addSql('COMMENT ON COLUMN session.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN session.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function rollback(): void
    {
        $this->addSql('ALTER TABLE session DROP CONSTRAINT FK_D044D5D4296CD8AE');
        $this->addSql('DROP TABLE session');
    }
}
