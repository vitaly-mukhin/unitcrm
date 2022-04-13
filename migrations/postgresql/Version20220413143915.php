<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220413143915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE core_user_id_seq CASCADE');
        $this->addSql('CREATE TABLE tbl_core_user (id SERIAL NOT NULL, login VARCHAR(64) NOT NULL, password VARCHAR(255) NOT NULL, state SMALLINT NOT NULL, date_created TIMESTAMP(0) WITH TIME ZONE NOT NULL, date_updated TIMESTAMP(0) WITH TIME ZONE NOT NULL, email VARCHAR(255) DEFAULT NULL, is_deleted BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_login ON tbl_core_user (login)');
        $this->addSql('CREATE INDEX idx_state ON tbl_core_user (state)');
        $this->addSql('CREATE INDEX idx_date_created ON tbl_core_user (date_created)');
        $this->addSql('CREATE TABLE tbl_core_user_core_user_role (core_user_id INT NOT NULL, core_user_role_id INT NOT NULL, PRIMARY KEY(core_user_id, core_user_role_id))');
        $this->addSql('CREATE INDEX IDX_905AE745B57966A6 ON tbl_core_user_core_user_role (core_user_id)');
        $this->addSql('CREATE INDEX IDX_905AE74523BE857E ON tbl_core_user_core_user_role (core_user_role_id)');
        $this->addSql('CREATE TABLE tbl_core_user_role (id INT NOT NULL, title VARCHAR(255) NOT NULL, state SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE tbl_core_user_core_user_role ADD CONSTRAINT FK_905AE745B57966A6 FOREIGN KEY (core_user_id) REFERENCES tbl_core_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_core_user_core_user_role ADD CONSTRAINT FK_905AE74523BE857E FOREIGN KEY (core_user_role_id) REFERENCES tbl_core_user_role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tbl_core_user_core_user_role DROP CONSTRAINT FK_905AE745B57966A6');
        $this->addSql('ALTER TABLE tbl_core_user_core_user_role DROP CONSTRAINT FK_905AE74523BE857E');
        $this->addSql('CREATE SEQUENCE core_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE tbl_core_user');
        $this->addSql('DROP TABLE tbl_core_user_core_user_role');
        $this->addSql('DROP TABLE tbl_core_user_role');
    }
}
