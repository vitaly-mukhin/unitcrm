<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412121508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO tbl_core_user_role (id, title, state) VALUES(:id, :ttl, :stt)', ['id' => 1, 'ttl' => 'Адміністратор', 'stt' => 1,]);
        $this->addSql(
            'INSERT INTO tbl_core_user (login, password, email, state, is_deleted, date_created, date_updated) 
VALUES(:lgn, :pwd, :eml, :stt, :idl, :dc, :du)',
            [
                'lgn' => 'admin',
                'pwd' => '$2y$13$Wvq4mcLeYVd6cI4jh.ydI.jTJsVwDpnW0RQlrno4onCN90gwAxz8q',
                'eml' => 'admin@site.com',
                'stt' => 1, 'idl' => false,
                'dc'  => (new \DateTime())->format('Y-m-d H:i:s'),
                'du'  => (new \DateTime())->format('Y-m-d H:i:s'),
            ]);
        $this->addSql('INSERT INTO tbl_core_user_core_user_role (core_user_id, core_user_role_id) SELECT id, 1 FROM tbl_core_user WHERE login = :lgn', ['lgn' => 'admin',]);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tbl_core_user');
        $this->addSql('DROP TABLE tbl_core_user_core_user_role');
        $this->addSql('DROP TABLE tbl_core_user_role');
    }
}
