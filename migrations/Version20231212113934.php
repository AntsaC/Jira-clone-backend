<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231212113934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE collaboration_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE collaboration (id INT NOT NULL, project_id INT DEFAULT NULL, collaborator_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DA3AE323166D1F9C ON collaboration (project_id)');
        $this->addSql('CREATE INDEX IDX_DA3AE32330098C8C ON collaboration (collaborator_id)');
        $this->addSql('ALTER TABLE collaboration ADD CONSTRAINT FK_DA3AE323166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE collaboration ADD CONSTRAINT FK_DA3AE32330098C8C FOREIGN KEY (collaborator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE collaboration_id_seq CASCADE');
        $this->addSql('ALTER TABLE collaboration DROP CONSTRAINT FK_DA3AE323166D1F9C');
        $this->addSql('ALTER TABLE collaboration DROP CONSTRAINT FK_DA3AE32330098C8C');
        $this->addSql('DROP TABLE collaboration');
    }
}
