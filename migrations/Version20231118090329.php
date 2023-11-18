<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231118090329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_story ADD sprint_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_story ADD CONSTRAINT FK_994FF608C24077B FOREIGN KEY (sprint_id) REFERENCES sprint (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_994FF608C24077B ON user_story (sprint_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_story DROP CONSTRAINT FK_994FF608C24077B');
        $this->addSql('DROP INDEX IDX_994FF608C24077B');
        $this->addSql('ALTER TABLE user_story DROP sprint_id');
    }
}
