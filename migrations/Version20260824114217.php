<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260824114217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE marketplace_booking (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, product_id INT NOT NULL, agency_id INT NOT NULL, schedule_id INT DEFAULT NULL, reference VARCHAR(30) NOT NULL, date DATE NOT NULL, adults INT NOT NULL, children INT DEFAULT 0 NOT NULL, total_participants INT NOT NULL, unit_price DOUBLE PRECISION NOT NULL, total_price DOUBLE PRECISION NOT NULL, currency VARCHAR(10) DEFAULT \'MAD\' NOT NULL, customer_name VARCHAR(255) NOT NULL, customer_phone VARCHAR(50) NOT NULL, customer_email VARCHAR(255) NOT NULL, comments LONGTEXT DEFAULT NULL, status VARCHAR(20) DEFAULT \'PENDING\' NOT NULL, date_create DATETIME NOT NULL, date_update DATETIME NOT NULL, commission_amount DOUBLE PRECISION DEFAULT NULL, payment_status VARCHAR(20) DEFAULT NULL, UNIQUE INDEX UNIQ_4EA3EC2AEA34913 (reference), INDEX IDX_4EA3EC2A76ED395 (user_id), INDEX IDX_4EA3EC24584665A (product_id), INDEX IDX_4EA3EC2CDEADB2A (agency_id), INDEX IDX_4EA3EC2A40BC2D5 (schedule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE marketplace_booking ADD CONSTRAINT FK_4EA3EC2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE marketplace_booking ADD CONSTRAINT FK_4EA3EC24584665A FOREIGN KEY (product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marketplace_booking ADD CONSTRAINT FK_4EA3EC2CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marketplace_booking ADD CONSTRAINT FK_4EA3EC2A40BC2D5 FOREIGN KEY (schedule_id) REFERENCES excursion_schedule (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marketplace_booking DROP FOREIGN KEY FK_4EA3EC2A76ED395');
        $this->addSql('ALTER TABLE marketplace_booking DROP FOREIGN KEY FK_4EA3EC24584665A');
        $this->addSql('ALTER TABLE marketplace_booking DROP FOREIGN KEY FK_4EA3EC2CDEADB2A');
        $this->addSql('ALTER TABLE marketplace_booking DROP FOREIGN KEY FK_4EA3EC2A40BC2D5');
        $this->addSql('DROP TABLE marketplace_booking');
    }
}
