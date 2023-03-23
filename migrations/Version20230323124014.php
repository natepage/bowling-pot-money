<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20230323124014 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('CREATE TABLE achievement (id UUID NOT NULL, team_id UUID DEFAULT NULL, cost BIGINT NOT NULL, currency VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_96737FF1296CD8AE ON achievement (team_id)');
        $this->addSql('COMMENT ON COLUMN achievement.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN achievement.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE achievement ADD CONSTRAINT FK_96737FF1296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function rollback(): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE achievement DROP CONSTRAINT FK_96737FF1296CD8AE');
        $this->addSql('DROP TABLE achievement');
    }
}
