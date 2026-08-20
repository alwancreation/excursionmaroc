<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260820001559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agency ADD legal_name VARCHAR(255) DEFAULT NULL, ADD cover VARCHAR(255) DEFAULT NULL, ADD whatsapp VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, ADD languages_spoken VARCHAR(255) DEFAULT NULL, ADD years_experience INT DEFAULT NULL, ADD facebook_url VARCHAR(255) DEFAULT NULL, ADD instagram_url VARCHAR(255) DEFAULT NULL, ADD verified TINYINT(1) DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agency DROP legal_name, DROP cover, DROP whatsapp, DROP country, DROP languages_spoken, DROP years_experience, DROP facebook_url, DROP instagram_url, DROP verified');
    }
}
