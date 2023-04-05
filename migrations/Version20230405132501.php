<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20230405132501 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('CREATE TABLE app_user (id UUID NOT NULL, email VARCHAR(255) NOT NULL, email_verified BOOLEAN NOT NULL, locale VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, sub VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN app_user.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN app_user.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function rollback(): void
    {
        $this->addSql('DROP TABLE app_user');
    }
}
