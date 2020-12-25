<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201225173240 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create users table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("
            CREATE TABLE users(
                id int primary key,
                user_name varchar(50) unique,
                token varchar(50) unique
            )
        ");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
