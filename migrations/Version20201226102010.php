<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201226102010 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'create activities table';
    }

    public function up(Schema $schema) : void
    {
       $this->addSql("
            CREATE TABLE activities(
                id bigint primary key auto_increment,
                task_id int not null,
                operation tinyint not null,
                extra_data json,
                created_at datetime default CURRENT_TIMESTAMP
            )
       ");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
