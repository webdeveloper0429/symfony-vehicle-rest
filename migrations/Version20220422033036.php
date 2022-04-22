<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220422033036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Vehicle Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, date_added DATETIME NOT NULL, type VARCHAR(255) DEFAULT NULL, msrp DOUBLE PRECISION DEFAULT NULL, year INT DEFAULT NULL, make VARCHAR(255) DEFAULT NULL, model VARCHAR(255) DEFAULT NULL, miles INT DEFAULT NULL, vin VARCHAR(255) DEFAULT NULL, deleted TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vehicle');
    }
}
