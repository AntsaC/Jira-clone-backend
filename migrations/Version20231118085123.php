<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231118085123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE user_story_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_story (id INT NOT NULL, project_id INT NOT NULL, summary VARCHAR(300) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_994FF60166D1F9C ON user_story (project_id)');
        $this->addSql('ALTER TABLE user_story ADD CONSTRAINT FK_994FF60166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE user_story_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_story DROP CONSTRAINT FK_994FF60166D1F9C');
        $this->addSql('DROP TABLE user_story');
    }
}
