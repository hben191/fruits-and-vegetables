<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250209174058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create AbstractFood table, extending Vegetable and Fruit';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE abstract_food (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, quantity INT NOT NULL, unit VARCHAR(2) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE abstract_food');
    }
}
