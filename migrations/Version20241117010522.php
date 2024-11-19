<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241117010522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update the `amount` column in the `invoices` table to add a Doctrine custom type annotation `(DC2Type:amount)`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE invoices CHANGE amount amount INT UNSIGNED NOT NULL COMMENT \'(DC2Type:amount)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE invoices CHANGE amount amount INT UNSIGNED NOT NULL');
    }
}
