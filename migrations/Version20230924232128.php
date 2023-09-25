<?php
declare(strict_types=1);

namespace DoctrineMigrations;

final class Version20230924232128 extends AbstractMigration
{
    public function migrate(): void
    {
        $this->addSql('CREATE TABLE financial_activity (
            id UUID NOT NULL, 
            team_id UUID DEFAULT NULL, 
            team_member_id UUID DEFAULT NULL,
            session_id UUID DEFAULT NULL, 
            game_id UUID DEFAULT NULL, 
            title VARCHAR(255) NOT NULL, 
            type VARCHAR(255) NOT NULL,
            currency VARCHAR(255) NOT NULL,
            value BIGINT NOT NULL,   
            balance BIGINT NOT NULL, 
            sequential_number INT NOT NULL,  
            created_by_id UUID DEFAULT NULL, 
            updated_by_id UUID DEFAULT NULL,
            created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, 
            updated_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, 
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_141425EE48FD905 ON financial_activity (game_id)');
        $this->addSql('CREATE INDEX IDX_141425E613FECDF ON financial_activity (session_id)');
        $this->addSql('CREATE INDEX IDX_141425E296CD8AE ON financial_activity (team_id)');
        $this->addSql('CREATE INDEX IDX_141425EC292CD19 ON financial_activity (team_member_id)');
        $this->addSql('CREATE INDEX IDX_141425EB03A8386 ON financial_activity (created_by_id)');
        $this->addSql('CREATE INDEX IDX_141425E896DBBDE ON financial_activity (updated_by_id)');
        $this->addSql('COMMENT ON COLUMN financial_activity.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN financial_activity.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE financial_activity ADD CONSTRAINT FK_141425EE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE financial_activity ADD CONSTRAINT FK_141425E613FECDF FOREIGN KEY (session_id) REFERENCES session (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE financial_activity ADD CONSTRAINT FK_141425E296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE financial_activity ADD CONSTRAINT FK_141425EC292CD19 FOREIGN KEY (team_member_id) REFERENCES team_member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE financial_activity ADD CONSTRAINT FK_141425EB03A8386 FOREIGN KEY (created_by_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE financial_activity ADD CONSTRAINT FK_141425E896DBBDE FOREIGN KEY (updated_by_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function rollback(): void
    {
        $this->addSql('ALTER TABLE financial_activity DROP CONSTRAINT FK_141425EE48FD905');
        $this->addSql('ALTER TABLE financial_activity DROP CONSTRAINT FK_141425E613FECDF');
        $this->addSql('ALTER TABLE financial_activity DROP CONSTRAINT FK_141425E296CD8AE');
        $this->addSql('ALTER TABLE financial_activity DROP CONSTRAINT FK_141425EC292CD19');
        $this->addSql('ALTER TABLE financial_activity DROP CONSTRAINT FK_141425EB03A8386');
        $this->addSql('ALTER TABLE financial_activity DROP CONSTRAINT FK_141425E896DBBDE');
        $this->addSql('DROP TABLE financial_activity');
    }
}
