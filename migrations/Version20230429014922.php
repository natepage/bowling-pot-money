<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20230429014922 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('ALTER TABLE team_member ADD sequential_number INT NOT NULL');
    }

    public function rollback(): void
    {
        $this->addSql('ALTER TABLE team_member DROP sequential_number');
    }
}
