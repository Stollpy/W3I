<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210411172432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fan_account (id INT AUTO_INCREMENT NOT NULL, main_account_id INT DEFAULT NULL, id_page_insta VARCHAR(255) NOT NULL, id_page_fb VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, access_token VARCHAR(255) NOT NULL, INDEX IDX_153EB05FA3932BD9 (main_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fan_account ADD CONSTRAINT FK_153EB05FA3932BD9 FOREIGN KEY (main_account_id) REFERENCES main_account (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fan_account');
    }
}
