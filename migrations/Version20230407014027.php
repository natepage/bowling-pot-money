<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20230407014027 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('ALTER TABLE team_invite ADD created_by_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE team_invite ADD updated_by_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE team_invite ALTER access_level TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE team_invite ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE team_invite ADD CONSTRAINT FK_B1F9570EB03A8386 FOREIGN KEY (created_by_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_invite ADD CONSTRAINT FK_B1F9570E896DBBDE FOREIGN KEY (updated_by_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B1F9570EB03A8386 ON team_invite (created_by_id)');
        $this->addSql('CREATE INDEX IDX_B1F9570E896DBBDE ON team_invite (updated_by_id)');
        $this->addSql('ALTER TABLE team_member ALTER access_level TYPE VARCHAR(255)');
    }

    public function rollback(): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE team_member ALTER access_level TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE team_invite DROP CONSTRAINT FK_B1F9570EB03A8386');
        $this->addSql('ALTER TABLE team_invite DROP CONSTRAINT FK_B1F9570E896DBBDE');
        $this->addSql('DROP INDEX IDX_B1F9570EB03A8386');
        $this->addSql('DROP INDEX IDX_B1F9570E896DBBDE');
        $this->addSql('ALTER TABLE team_invite DROP created_by_id');
        $this->addSql('ALTER TABLE team_invite DROP updated_by_id');
        $this->addSql('ALTER TABLE team_invite ALTER access_level TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE team_invite ALTER status TYPE VARCHAR(255)');
    }
}
