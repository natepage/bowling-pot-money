<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20231004055720 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('ALTER TABLE game ADD balance BIGINT DEFAULT 0 NOT NULL');
    }

    public function rollback(): void
    {
        $this->addSql('ALTER TABLE game DROP balance');
    }
}
