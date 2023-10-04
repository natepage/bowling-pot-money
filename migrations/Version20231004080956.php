<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20231004080956 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('CREATE INDEX IDX_232B318C613FECDF7B00651C ON game (session_id, status)');
    }

    public function rollback(): void
    {
        $this->addSql('DROP INDEX IDX_232B318C613FECDF7B00651C');
    }
}
