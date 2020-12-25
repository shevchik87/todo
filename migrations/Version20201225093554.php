<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201225093554 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create task table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("
            CREATE TABLE tasks(
                id int primary key auto_increment,
                user_id int not null,
                content text not null,
                due_date date default null,
                status tinyint,
                created_at datetime,
                updated_at datetime
            )
        ");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
