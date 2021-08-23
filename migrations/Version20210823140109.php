<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210823140109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add detail field to PointOfSale table ';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point_of_sale ADD detail LONGTEXT DEFAULT NULL, DROP updated_at, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point_of_sale ADD updated_at DATETIME DEFAULT NULL, DROP detail, CHANGE created_at created_at DATETIME NOT NULL');
    }
}
