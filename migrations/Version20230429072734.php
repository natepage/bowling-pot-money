<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20230429072734 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('CREATE TABLE game (id UUID NOT NULL, session_id UUID DEFAULT NULL, team_member_id UUID DEFAULT NULL, score INT DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_232B318C613FECDF ON game (session_id)');
        $this->addSql('CREATE INDEX IDX_232B318CC292CD19 ON game (team_member_id)');
        $this->addSql('COMMENT ON COLUMN game.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN game.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C613FECDF FOREIGN KEY (session_id) REFERENCES session (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CC292CD19 FOREIGN KEY (team_member_id) REFERENCES team_member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function rollback(): void
    {
        $this->addSql('ALTER TABLE game DROP CONSTRAINT FK_232B318C613FECDF');
        $this->addSql('ALTER TABLE game DROP CONSTRAINT FK_232B318CC292CD19');
        $this->addSql('DROP TABLE game');
    }
}
