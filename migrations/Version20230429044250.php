<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20230429044250 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('CREATE TABLE session_member (id UUID NOT NULL, session_id UUID DEFAULT NULL, team_member_id UUID DEFAULT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1F8FF021613FECDF ON session_member (session_id)');
        $this->addSql('CREATE INDEX IDX_1F8FF021C292CD19 ON session_member (team_member_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F8FF021613FECDFC292CD19 ON session_member (session_id, team_member_id)');
        $this->addSql('COMMENT ON COLUMN session_member.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN session_member.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE session_member ADD CONSTRAINT FK_1F8FF021613FECDF FOREIGN KEY (session_id) REFERENCES session (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session_member ADD CONSTRAINT FK_1F8FF021C292CD19 FOREIGN KEY (team_member_id) REFERENCES team_member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function rollback(): void
    {
        $this->addSql('ALTER TABLE session_member DROP CONSTRAINT FK_1F8FF021613FECDF');
        $this->addSql('ALTER TABLE session_member DROP CONSTRAINT FK_1F8FF021C292CD19');
        $this->addSql('DROP TABLE session_member');
    }
}
