<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241117021010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update the `email` column in the `users` table to add a Doctrine custom type annotation `(DC2Type:email)`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(300) NOT NULL COMMENT \'(DC2Type:email)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(300) NOT NULL');
    }
}
