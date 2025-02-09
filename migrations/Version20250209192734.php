<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250209192734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added fruit and vegetable collections';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE fruit_collection (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vegetable_collection (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abstract_food ADD vegetable_collection_id INT DEFAULT NULL, ADD fruit_collection_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abstract_food ADD CONSTRAINT FK_27DC5AF660B192F2 FOREIGN KEY (vegetable_collection_id) REFERENCES vegetable_collection (id)');
        $this->addSql('ALTER TABLE abstract_food ADD CONSTRAINT FK_27DC5AF63746D6F6 FOREIGN KEY (fruit_collection_id) REFERENCES fruit_collection (id)');
        $this->addSql('CREATE INDEX IDX_27DC5AF660B192F2 ON abstract_food (vegetable_collection_id)');
        $this->addSql('CREATE INDEX IDX_27DC5AF63746D6F6 ON abstract_food (fruit_collection_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE abstract_food DROP FOREIGN KEY FK_27DC5AF63746D6F6');
        $this->addSql('ALTER TABLE abstract_food DROP FOREIGN KEY FK_27DC5AF660B192F2');
        $this->addSql('DROP TABLE fruit_collection');
        $this->addSql('DROP TABLE vegetable_collection');
        $this->addSql('DROP INDEX IDX_27DC5AF660B192F2 ON abstract_food');
        $this->addSql('DROP INDEX IDX_27DC5AF63746D6F6 ON abstract_food');
        $this->addSql('ALTER TABLE abstract_food DROP vegetable_collection_id, DROP fruit_collection_id');
    }
}
