<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20230323120651 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('CREATE TABLE team (id UUID NOT NULL, currency VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN team.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN team.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function rollback(): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE team');
    }
}
