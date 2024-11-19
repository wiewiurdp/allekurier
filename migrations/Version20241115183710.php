<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241115183710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adding is_active field to users table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ADD is_active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP is_active');
    }
}
