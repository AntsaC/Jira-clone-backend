<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231207140736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("create or replace view view_ordered_stories as with recursive stories as (
    select * from user_story u where u.previous_id is null
    union
    select
        u2.*
    from user_story u2
    join stories s on s.id = u2.previous_id
)
select * from stories");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop view view_ordered_stories');
    }
}
