<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260821014631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD meta_id INT DEFAULT NULL, ADD category_slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C139FCA6F9 FOREIGN KEY (meta_id) REFERENCES meta (meta_id)');
        $this->addSql('CREATE INDEX IDX_64C19C139FCA6F9 ON category (meta_id)');
        $this->addSql('ALTER TABLE destination ADD meta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE destination ADD CONSTRAINT FK_3EC63EAA39FCA6F9 FOREIGN KEY (meta_id) REFERENCES meta (meta_id)');
        $this->addSql('CREATE INDEX IDX_3EC63EAA39FCA6F9 ON destination (meta_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE destination DROP FOREIGN KEY FK_3EC63EAA39FCA6F9');
        $this->addSql('DROP INDEX IDX_3EC63EAA39FCA6F9 ON destination');
        $this->addSql('ALTER TABLE destination DROP meta_id');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C139FCA6F9');
        $this->addSql('DROP INDEX IDX_64C19C139FCA6F9 ON category');
        $this->addSql('ALTER TABLE category DROP meta_id, DROP category_slug');
    }
}
