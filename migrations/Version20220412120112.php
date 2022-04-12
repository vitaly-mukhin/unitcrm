<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412120112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tbl_core_user (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
    login VARCHAR(64) NOT NULL, 
    password VARCHAR(255) NOT NULL, 
    state SMALLINT NOT NULL, 
    date_created DATETIME NOT NULL, 
    date_updated DATETIME NOT NULL, 
    email VARCHAR(255) DEFAULT NULL, 
    is_deleted BOOLEAN NOT NULL
                           )');
        $this->addSql('CREATE INDEX idx_login ON tbl_core_user (login)');
        $this->addSql('CREATE INDEX idx_state ON tbl_core_user (state)');
        $this->addSql('CREATE INDEX idx_date_created ON tbl_core_user (date_created)');
        $this->addSql('CREATE TABLE tbl_core_user_role (
    id INTEGER PRIMARY KEY NOT NULL, 
    title VARCHAR(255) NOT NULL, 
    state SMALLINT NOT NULL
                                )');
        $this->addSql('CREATE TABLE tbl_core_user_core_user_role (
    core_user_id INTEGER NOT NULL, 
    core_user_role_id INTEGER NOT NULL, 
    PRIMARY KEY(core_user_id, core_user_role_id)
                                          )');
        $this->addSql('CREATE INDEX idx_cucur_cu ON tbl_core_user_core_user_role (core_user_id)');
        $this->addSql('CREATE INDEX idx_cucur_cur ON tbl_core_user_core_user_role (core_user_role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tbl_core_user');
        $this->addSql('DROP TABLE tbl_core_user_core_user_role');
        $this->addSql('DROP TABLE tbl_core_user_role');
    }
}
