<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration as DoctrineAbstractMigration;

abstract class AbstractMigration extends DoctrineAbstractMigration
{
    public function down(Schema $schema): void
    {
        $this->checkPlatform();
        $this->rollback();
    }

    public function up(Schema $schema): void
    {
        $this->checkPlatform();
        $this->migrate();
    }

    abstract protected function migrate(): void;

    abstract protected function rollback(): void;

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    private function checkPlatform(): void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform() instanceof PostgreSQLPlatform === false,
            \sprintf("Migration can only be executed safely on '%s'", PostgreSQLPlatform::class)
        );
    }
}