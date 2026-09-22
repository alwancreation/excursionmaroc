<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260820190300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE excursion_image (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, path VARCHAR(255) NOT NULL, alt_text VARCHAR(255) DEFAULT NULL, position INT DEFAULT 0 NOT NULL, is_main TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_17F93B114584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE excursion_itinerary (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, position INT DEFAULT 0 NOT NULL, time VARCHAR(20) DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, duration VARCHAR(100) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, INDEX IDX_6C9514E74584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE excursion_schedule (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, date DATE NOT NULL, time VARCHAR(20) DEFAULT NULL, capacity INT NOT NULL, remaining_capacity INT NOT NULL, price DOUBLE PRECISION DEFAULT NULL, status VARCHAR(20) DEFAULT \'OPEN\' NOT NULL, INDEX IDX_E4EB9D764584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE excursion_image ADD CONSTRAINT FK_17F93B114584665A FOREIGN KEY (product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE excursion_itinerary ADD CONSTRAINT FK_6C9514E74584665A FOREIGN KEY (product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE excursion_schedule ADD CONSTRAINT FK_E4EB9D764584665A FOREIGN KEY (product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD status VARCHAR(30) DEFAULT \'DRAFT\' NOT NULL, ADD min_persons INT DEFAULT NULL, ADD min_age INT DEFAULT NULL, ADD transport_included TINYINT(1) DEFAULT NULL, ADD guide_included TINYINT(1) DEFAULT NULL, ADD meals_included TINYINT(1) DEFAULT NULL, ADD inclusions LONGTEXT DEFAULT NULL, ADD exclusions LONGTEXT DEFAULT NULL, ADD meeting_point VARCHAR(255) DEFAULT NULL, ADD departure_time VARCHAR(20) DEFAULT NULL, ADD return_time VARCHAR(20) DEFAULT NULL, ADD terms LONGTEXT DEFAULT NULL, ADD cancellation_policy LONGTEXT DEFAULT NULL');
        // Backfill: preserve current public visibility of pre-existing products.
        // The new status column defaults every row to DRAFT above; without this,
        // every excursion already live today (is_available = 1) would vanish
        // from the public site the moment status=PUBLISHED filtering ships.
        $this->addSql("UPDATE product SET status = 'PUBLISHED' WHERE is_available = 1");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE excursion_image DROP FOREIGN KEY FK_17F93B114584665A');
        $this->addSql('ALTER TABLE excursion_itinerary DROP FOREIGN KEY FK_6C9514E74584665A');
        $this->addSql('ALTER TABLE excursion_schedule DROP FOREIGN KEY FK_E4EB9D764584665A');
        $this->addSql('DROP TABLE excursion_image');
        $this->addSql('DROP TABLE excursion_itinerary');
        $this->addSql('DROP TABLE excursion_schedule');
        $this->addSql('ALTER TABLE product DROP status, DROP min_persons, DROP min_age, DROP transport_included, DROP guide_included, DROP meals_included, DROP inclusions, DROP exclusions, DROP meeting_point, DROP departure_time, DROP return_time, DROP terms, DROP cancellation_policy');
    }
}
