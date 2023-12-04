<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231203161019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE criteria_acceptance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE criteria_acceptance (id INT NOT NULL, user_story_id INT NOT NULL, criteria VARCHAR(255) NOT NULL, checked BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_58FD5CB4AD0A436 ON criteria_acceptance (user_story_id)');
        $this->addSql('ALTER TABLE criteria_acceptance ADD CONSTRAINT FK_58FD5CB4AD0A436 FOREIGN KEY (user_story_id) REFERENCES user_story (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE criteria_acceptance_id_seq CASCADE');
        $this->addSql('ALTER TABLE criteria_acceptance DROP CONSTRAINT FK_58FD5CB4AD0A436');
        $this->addSql('DROP TABLE criteria_acceptance');
    }
}
