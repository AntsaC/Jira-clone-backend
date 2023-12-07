<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231207090048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_story ADD previous_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_story DROP index');
        $this->addSql('ALTER TABLE user_story ADD CONSTRAINT FK_994FF602DE62210 FOREIGN KEY (previous_id) REFERENCES user_story (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_994FF602DE62210 ON user_story (previous_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_story DROP CONSTRAINT FK_994FF602DE62210');
        $this->addSql('DROP INDEX IDX_994FF602DE62210');
        $this->addSql('ALTER TABLE user_story ADD index SMALLINT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE user_story DROP previous_id');
    }
}
