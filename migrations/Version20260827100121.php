<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260827100121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX idx_booking_status ON marketplace_booking (status)');
        $this->addSql('CREATE INDEX idx_product_status ON product (status)');
        $this->addSql('CREATE INDEX idx_review_status ON review (status)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX idx_booking_status ON marketplace_booking');
        $this->addSql('DROP INDEX idx_review_status ON review');
        $this->addSql('DROP INDEX idx_product_status ON product');
    }
}
