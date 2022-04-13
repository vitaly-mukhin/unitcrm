<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220413150624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tbl_core_sessions (
    sess_id VARCHAR(128) NOT NULL PRIMARY KEY,
    sess_data BYTEA NOT NULL,
    sess_lifetime INTEGER NOT NULL,
    sess_time INTEGER NOT NULL
);');
        $this->addSql('CREATE INDEX sessions_sess_lifetime_idx ON tbl_core_sessions (sess_lifetime);');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tbl_core_sessions');
        // this down() migration is auto-generated, please modify it to your needs
    }
}
