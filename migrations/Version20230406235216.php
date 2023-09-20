<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20230406235216 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('CREATE TABLE achievement (id UUID NOT NULL, team_id UUID DEFAULT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, cost BIGINT NOT NULL, currency VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_96737FF1296CD8AE ON achievement (team_id)');
        $this->addSql('CREATE INDEX IDX_96737FF1B03A8386 ON achievement (created_by_id)');
        $this->addSql('CREATE INDEX IDX_96737FF1896DBBDE ON achievement (updated_by_id)');
        $this->addSql('COMMENT ON COLUMN achievement.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN achievement.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE app_user (id UUID NOT NULL, email VARCHAR(255) NOT NULL, email_verified BOOLEAN NOT NULL, locale VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, sub VARCHAR(255) NOT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9E7927C74 ON app_user (email)');
        $this->addSql('COMMENT ON COLUMN app_user.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN app_user.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE team (id UUID NOT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, currency VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C4E0A61FB03A8386 ON team (created_by_id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61F896DBBDE ON team (updated_by_id)');
        $this->addSql('COMMENT ON COLUMN team.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN team.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE achievement ADD CONSTRAINT FK_96737FF1296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE achievement ADD CONSTRAINT FK_96737FF1B03A8386 FOREIGN KEY (created_by_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE achievement ADD CONSTRAINT FK_96737FF1896DBBDE FOREIGN KEY (updated_by_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FB03A8386 FOREIGN KEY (created_by_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F896DBBDE FOREIGN KEY (updated_by_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function rollback(): void
    {
        $this->addSql('ALTER TABLE achievement DROP CONSTRAINT FK_96737FF1296CD8AE');
        $this->addSql('ALTER TABLE achievement DROP CONSTRAINT FK_96737FF1B03A8386');
        $this->addSql('ALTER TABLE achievement DROP CONSTRAINT FK_96737FF1896DBBDE');
        $this->addSql('ALTER TABLE team DROP CONSTRAINT FK_C4E0A61FB03A8386');
        $this->addSql('ALTER TABLE team DROP CONSTRAINT FK_C4E0A61F896DBBDE');
        $this->addSql('DROP TABLE achievement');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE team');
    }
}
