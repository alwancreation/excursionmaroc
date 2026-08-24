<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260824152649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, booking_id INT NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, agency_id INT NOT NULL, rating INT NOT NULL, comment LONGTEXT NOT NULL, status VARCHAR(20) DEFAULT \'PUBLISHED\' NOT NULL, agency_reply LONGTEXT DEFAULT NULL, agency_reply_date DATETIME DEFAULT NULL, date_create DATETIME NOT NULL, UNIQUE INDEX UNIQ_794381C63301C60 (booking_id), INDEX IDX_794381C6A76ED395 (user_id), INDEX IDX_794381C64584665A (product_id), INDEX IDX_794381C6CDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C63301C60 FOREIGN KEY (booking_id) REFERENCES marketplace_booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C64584665A FOREIGN KEY (product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C63301C60');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6A76ED395');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C64584665A');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6CDEADB2A');
        $this->addSql('DROP TABLE review');
    }
}
