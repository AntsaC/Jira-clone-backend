<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231212121935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE story_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE story_status (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE user_story ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_story ADD CONSTRAINT FK_994FF606BF700BD FOREIGN KEY (status_id) REFERENCES story_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_994FF606BF700BD ON user_story (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_story DROP CONSTRAINT FK_994FF606BF700BD');
        $this->addSql('DROP SEQUENCE story_status_id_seq CASCADE');
        $this->addSql('DROP TABLE story_status');
        $this->addSql('DROP INDEX IDX_994FF606BF700BD');
        $this->addSql('ALTER TABLE user_story DROP status_id');
    }
}
