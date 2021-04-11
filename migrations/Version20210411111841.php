<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210411111841 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE main_account ADD id_page_fb VARCHAR(255) NOT NULL, ADD id_page_insta VARCHAR(255) NOT NULL, DROP id_facebook_page, DROP id_instagram_page');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE main_account ADD id_facebook_page INT NOT NULL, ADD id_instagram_page INT NOT NULL, DROP id_page_fb, DROP id_page_insta');
    }
}
