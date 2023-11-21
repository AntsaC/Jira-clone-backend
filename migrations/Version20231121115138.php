<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231121115138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE sprint_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sprint_status (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE project ALTER current_sprint_index DROP DEFAULT');
        $this->addSql('ALTER TABLE sprint ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sprint ADD CONSTRAINT FK_EF8055B76BF700BD FOREIGN KEY (status_id) REFERENCES sprint_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_EF8055B76BF700BD ON sprint (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE sprint DROP CONSTRAINT FK_EF8055B76BF700BD');
        $this->addSql('DROP SEQUENCE sprint_status_id_seq CASCADE');
        $this->addSql('DROP TABLE sprint_status');
        $this->addSql('ALTER TABLE project ALTER current_sprint_index SET DEFAULT 0');
        $this->addSql('DROP INDEX IDX_EF8055B76BF700BD');
        $this->addSql('ALTER TABLE sprint DROP status_id');
    }
}
