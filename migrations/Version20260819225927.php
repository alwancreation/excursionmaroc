<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260819225927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agency (id INT AUTO_INCREMENT NOT NULL, utilisateur INT DEFAULT NULL, city_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, long_description LONGTEXT DEFAULT NULL, short_description LONGTEXT DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, valid TINYINT(1) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, date_create DATETIME DEFAULT NULL, rc VARCHAR(255) DEFAULT NULL, ice VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, INDEX IDX_70C0C6E61D1C63B3 (utilisateur), INDEX IDX_70C0C6E68BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE asset (asset_id INT AUTO_INCREMENT NOT NULL, asset_is_main TINYINT(1) DEFAULT NULL, asset_base_path VARCHAR(255) DEFAULT NULL, asset_title VARCHAR(255) DEFAULT NULL, asset_alt VARCHAR(255) DEFAULT NULL, asset_link VARCHAR(255) DEFAULT NULL, asset_link_title VARCHAR(255) DEFAULT NULL, asset_description LONGTEXT DEFAULT NULL, asset_type INT DEFAULT NULL, PRIMARY KEY(asset_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, package_id INT DEFAULT NULL, date_create DATETIME NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, client_name VARCHAR(255) DEFAULT NULL, number_of_adults INT NOT NULL, number_of_children INT NOT NULL, pax INT NOT NULL, status INT DEFAULT 0, INDEX IDX_E00CEDDE19EB6921 (client_id), INDEX IDX_E00CEDDEF44CABFF (package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_guide (id INT AUTO_INCREMENT NOT NULL, guide_id INT DEFAULT NULL, booking_id INT DEFAULT NULL, date_create DATETIME NOT NULL, date_start DATETIME DEFAULT NULL, date_end DATETIME DEFAULT NULL, duration DOUBLE PRECISION DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, total_price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_5BE23A80D7ED1D4B (guide_id), INDEX IDX_5BE23A803301C60 (booking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_product (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, booking_id INT DEFAULT NULL, date_create DATETIME NOT NULL, date_start DATETIME DEFAULT NULL, date_end DATETIME DEFAULT NULL, product_name VARCHAR(255) DEFAULT NULL, pax INT NOT NULL, number_of_adults INT NOT NULL, number_of_children INT NOT NULL, price_per_adult DOUBLE PRECISION NOT NULL, price_per_child DOUBLE PRECISION NOT NULL, total_price DOUBLE PRECISION NOT NULL, hour_start DATETIME DEFAULT NULL, flight_number VARCHAR(255) DEFAULT NULL, airport VARCHAR(255) DEFAULT NULL, flight_company VARCHAR(255) DEFAULT NULL, INDEX IDX_89F4418D4584665A (product_id), INDEX IDX_89F4418D3301C60 (booking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (category_id INT AUTO_INCREMENT NOT NULL, category_icon_id INT DEFAULT NULL, category_name VARCHAR(255) DEFAULT NULL, category_long_description TEXT DEFAULT NULL, category_short_description TEXT DEFAULT NULL, INDEX category_icon_id (category_icon_id), PRIMARY KEY(category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) DEFAULT NULL, date_create DATETIME DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT \'normal\', address VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE custom_property (custom_property_id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, user_id INT DEFAULT NULL, custom_property_name TEXT DEFAULT NULL, custom_property_description TEXT DEFAULT NULL, custom_property_order INT DEFAULT NULL, custom_property_type INT DEFAULT NULL, INDEX IDX_6E20FBBA4584665A (product_id), INDEX IDX_6E20FBBAA76ED395 (user_id), PRIMARY KEY(custom_property_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE destination (destination_id INT AUTO_INCREMENT NOT NULL, destination_category_id INT DEFAULT NULL, destination_icon_id INT DEFAULT NULL, asset_id INT DEFAULT NULL, destination_name VARCHAR(255) DEFAULT NULL, destination_slug VARCHAR(255) DEFAULT NULL, INDEX IDX_3EC63EAA5DA1941 (asset_id), INDEX destination_name (destination_name), INDEX destination_category_id (destination_category_id), INDEX destination_icon_id (destination_icon_id), PRIMARY KEY(destination_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entity_history (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_create DATETIME DEFAULT NULL, entity_name VARCHAR(255) DEFAULT NULL, entity_id VARCHAR(255) DEFAULT NULL, action_name VARCHAR(255) DEFAULT NULL, action_value LONGTEXT DEFAULT NULL, INDEX IDX_B4774268A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ext_translations_element (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(191) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX element_translation_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (message_id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, vehicle_id INT DEFAULT NULL, theme_id INT DEFAULT NULL, destination_start_id INT DEFAULT NULL, destination_end_id INT DEFAULT NULL, product_id INT DEFAULT NULL, number_persons INT DEFAULT NULL, number_of_children INT DEFAULT NULL, date_start DATETIME DEFAULT NULL, date_end DATETIME DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, message_content LONGTEXT DEFAULT NULL, date_create DATETIME DEFAULT NULL, INDEX IDX_B6BD307F12469DE2 (category_id), INDEX IDX_B6BD307F545317D1 (vehicle_id), INDEX IDX_B6BD307F59027487 (theme_id), INDEX IDX_B6BD307F3C8D39AA (destination_start_id), INDEX IDX_B6BD307FB0841587 (destination_end_id), INDEX IDX_B6BD307F4584665A (product_id), PRIMARY KEY(message_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meta (meta_id INT AUTO_INCREMENT NOT NULL, meta_title VARCHAR(150) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, meta_plus LONGTEXT DEFAULT NULL, PRIMARY KEY(meta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE month (month_id INT AUTO_INCREMENT NOT NULL, month_name VARCHAR(255) DEFAULT NULL, month_code VARCHAR(255) DEFAULT NULL, PRIMARY KEY(month_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE package (id INT AUTO_INCREMENT NOT NULL, date_create DATETIME NOT NULL, name VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE package_guide (id INT AUTO_INCREMENT NOT NULL, guide_id INT DEFAULT NULL, package_id INT DEFAULT NULL, date_create DATETIME NOT NULL, date_start DATETIME DEFAULT NULL, date_end DATETIME DEFAULT NULL, duration DOUBLE PRECISION DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, total_price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_5F9AC0D2D7ED1D4B (guide_id), INDEX IDX_5F9AC0D2F44CABFF (package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE package_product (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, package_id INT DEFAULT NULL, date_create DATETIME NOT NULL, product_name VARCHAR(255) DEFAULT NULL, price_per_adult DOUBLE PRECISION NOT NULL, price_per_child DOUBLE PRECISION NOT NULL, INDEX IDX_5C1161214584665A (product_id), INDEX IDX_5C116121F44CABFF (package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (page_id INT AUTO_INCREMENT NOT NULL, asset_id INT DEFAULT NULL, meta_id INT DEFAULT NULL, page_name VARCHAR(150) DEFAULT NULL, page_title VARCHAR(255) DEFAULT NULL, page_sub_title VARCHAR(255) DEFAULT NULL, page_long_description LONGTEXT DEFAULT NULL, page_short_description LONGTEXT DEFAULT NULL, INDEX IDX_140AB6205DA1941 (asset_id), INDEX IDX_140AB62039FCA6F9 (meta_id), PRIMARY KEY(page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (product_id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, meta_id INT DEFAULT NULL, destination_id INT DEFAULT NULL, destination_from_id INT DEFAULT NULL, attached_file_id INT DEFAULT NULL, agency INT DEFAULT NULL, product_name VARCHAR(255) DEFAULT NULL, product_title VARCHAR(255) DEFAULT NULL, product_slug VARCHAR(255) DEFAULT NULL, duration VARCHAR(255) DEFAULT NULL, available_places INT DEFAULT NULL, is_private TINYINT(1) DEFAULT NULL, is_available TINYINT(1) DEFAULT NULL, difficulty VARCHAR(255) DEFAULT NULL, max_persons INT DEFAULT NULL, product_duration VARCHAR(255) DEFAULT NULL, product_short_description TEXT DEFAULT NULL, product_video_html TEXT DEFAULT NULL, product_map_html TEXT DEFAULT NULL, product_long_description TEXT DEFAULT NULL, product_price DOUBLE PRECISION DEFAULT NULL, product_saint_sylvester_price DOUBLE PRECISION DEFAULT NULL, product_order INT DEFAULT NULL, custom_payment_percent INT DEFAULT NULL, INDEX IDX_D34A04AD39FCA6F9 (meta_id), INDEX IDX_D34A04AD16F7E673 (destination_from_id), INDEX IDX_D34A04ADD62F4668 (attached_file_id), INDEX IDX_D34A04AD70C0C6E6 (agency), INDEX destination_id (destination_id), INDEX category_id (category_id), PRIMARY KEY(product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_has_asset (product_id INT NOT NULL, asset_id INT NOT NULL, INDEX IDX_9786FC6F4584665A (product_id), INDEX IDX_9786FC6F5DA1941 (asset_id), PRIMARY KEY(product_id, asset_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE related_product (product_id INT NOT NULL, related_product_id INT NOT NULL, INDEX IDX_EC53CE084584665A (product_id), INDEX IDX_EC53CE08CF496EEA (related_product_id), PRIMARY KEY(product_id, related_product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_in_month (product_id INT NOT NULL, month_id INT NOT NULL, INDEX IDX_FF364EF4584665A (product_id), INDEX IDX_FF364EFA0CBDE4 (month_id), PRIMARY KEY(product_id, month_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_has_destination (product_id INT NOT NULL, destination_id INT NOT NULL, INDEX IDX_65ADBB304584665A (product_id), INDEX IDX_65ADBB30816C6140 (destination_id), PRIMARY KEY(product_id, destination_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_has_theme (product_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_25C413B4584665A (product_id), INDEX IDX_25C413B59027487 (theme_id), PRIMARY KEY(product_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_price (product_price_id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, user_id INT DEFAULT NULL, price_1 DOUBLE PRECISION DEFAULT NULL, price_2 DOUBLE PRECISION DEFAULT NULL, price_3 DOUBLE PRECISION DEFAULT NULL, price_4 DOUBLE PRECISION DEFAULT NULL, price_5 DOUBLE PRECISION DEFAULT NULL, price_6 DOUBLE PRECISION DEFAULT NULL, price_7 DOUBLE PRECISION DEFAULT NULL, price_8 DOUBLE PRECISION DEFAULT NULL, price_9 DOUBLE PRECISION DEFAULT NULL, price_10 DOUBLE PRECISION DEFAULT NULL, price_11 DOUBLE PRECISION DEFAULT NULL, price_12 DOUBLE PRECISION DEFAULT NULL, price_13 DOUBLE PRECISION DEFAULT NULL, price_14 DOUBLE PRECISION DEFAULT NULL, price_14_plus DOUBLE PRECISION DEFAULT NULL, child_reduction DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_6B9459854584665A (product_id), INDEX IDX_6B945985A76ED395 (user_id), PRIMARY KEY(product_price_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (section_id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, asset_id INT DEFAULT NULL, section_title VARCHAR(255) DEFAULT NULL, section_sub_title VARCHAR(255) DEFAULT NULL, section_description TEXT DEFAULT NULL, section_order INT DEFAULT NULL, section_type INT DEFAULT NULL, INDEX IDX_2D737AEFC4663E4 (page_id), INDEX IDX_2D737AEF5DA1941 (asset_id), PRIMARY KEY(section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_has_asset (section_id INT NOT NULL, asset_id INT NOT NULL, INDEX IDX_9B6B3A67D823E37A (section_id), INDEX IDX_9B6B3A675DA1941 (asset_id), PRIMARY KEY(section_id, asset_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_has_product (section_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_A24A1309D823E37A (section_id), INDEX IDX_A24A13094584665A (product_id), PRIMARY KEY(section_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_has_theme (section_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_EB18733D823E37A (section_id), INDEX IDX_EB1873359027487 (theme_id), PRIMARY KEY(section_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_has_destination (section_id INT NOT NULL, destination_id INT NOT NULL, INDEX IDX_C2A444A7D823E37A (section_id), INDEX IDX_C2A444A7816C6140 (destination_id), PRIMARY KEY(section_id, destination_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) DEFAULT NULL, value LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider (slider_id INT AUTO_INCREMENT NOT NULL, slider_name VARCHAR(255) DEFAULT NULL, slider_title VARCHAR(255) DEFAULT NULL, slider_description LONGTEXT DEFAULT NULL, PRIMARY KEY(slider_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider_has_asset (slider_id INT NOT NULL, asset_id INT NOT NULL, INDEX IDX_B09013BB2CCC9638 (slider_id), INDEX IDX_B09013BB5DA1941 (asset_id), PRIMARY KEY(slider_id, asset_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (theme_id INT AUTO_INCREMENT NOT NULL, theme_name VARCHAR(255) DEFAULT NULL, theme_short_description TEXT DEFAULT NULL, theme_long_description TEXT DEFAULT NULL, PRIMARY KEY(theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme_has_asset (theme_id INT NOT NULL, asset_id INT NOT NULL, INDEX IDX_37E5906F59027487 (theme_id), INDEX IDX_37E5906F5DA1941 (asset_id), PRIMARY KEY(theme_id, asset_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, asset_id INT DEFAULT NULL, asset_identity_id INT DEFAULT NULL, asset_driver_license_id INT DEFAULT NULL, asset_medical_visit_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, last_login DATETIME DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, facebook_id VARCHAR(255) DEFAULT NULL, user_first_name VARCHAR(150) DEFAULT NULL, user_last_name VARCHAR(150) DEFAULT NULL, user_phone VARCHAR(150) DEFAULT NULL, user_type VARCHAR(150) DEFAULT NULL, user_day_price DOUBLE PRECISION DEFAULT NULL, user_half_day_price DOUBLE PRECISION DEFAULT NULL, user_address VARCHAR(150) DEFAULT NULL, driver_license_expiration_date DATETIME DEFAULT NULL, medical_visit_expiration_date DATETIME DEFAULT NULL, internal TINYINT(1) DEFAULT NULL, start_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6495DA1941 (asset_id), INDEX IDX_8D93D64974468DA1 (asset_identity_id), INDEX IDX_8D93D64973AC9AE0 (asset_driver_license_id), INDEX IDX_8D93D64930E0B894 (asset_medical_visit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_agency (agency_id INT NOT NULL, user_id INT NOT NULL, role VARCHAR(255) DEFAULT NULL, INDEX IDX_1592DDDBCDEADB2A (agency_id), INDEX IDX_1592DDDBA76ED395 (user_id), PRIMARY KEY(agency_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (vehicle_id INT AUTO_INCREMENT NOT NULL, vehicle_name VARCHAR(255) DEFAULT NULL, vehicle_short_description TEXT DEFAULT NULL, vehicle_long_description TEXT DEFAULT NULL, vehicle_price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(vehicle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle_has_asset (vehicle_id INT NOT NULL, asset_id INT NOT NULL, INDEX IDX_E990FB0545317D1 (vehicle_id), INDEX IDX_E990FB05DA1941 (asset_id), PRIMARY KEY(vehicle_id, asset_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agency ADD CONSTRAINT FK_70C0C6E61D1C63B3 FOREIGN KEY (utilisateur) REFERENCES user (id)');
        $this->addSql('ALTER TABLE agency ADD CONSTRAINT FK_70C0C6E68BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEF44CABFF FOREIGN KEY (package_id) REFERENCES package (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE booking_guide ADD CONSTRAINT FK_5BE23A80D7ED1D4B FOREIGN KEY (guide_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_guide ADD CONSTRAINT FK_5BE23A803301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_product ADD CONSTRAINT FK_89F4418D4584665A FOREIGN KEY (product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_product ADD CONSTRAINT FK_89F4418D3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C19361974C FOREIGN KEY (category_icon_id) REFERENCES asset (asset_id)');
        $this->addSql('ALTER TABLE custom_property ADD CONSTRAINT FK_6E20FBBA4584665A FOREIGN KEY (product_id) REFERENCES product (product_id)');
        $this->addSql('ALTER TABLE custom_property ADD CONSTRAINT FK_6E20FBBAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE destination ADD CONSTRAINT FK_3EC63EAA377476D9 FOREIGN KEY (destination_category_id) REFERENCES category (category_id)');
        $this->addSql('ALTER TABLE destination ADD CONSTRAINT FK_3EC63EAA3A80E84A FOREIGN KEY (destination_icon_id) REFERENCES asset (asset_id)');
        $this->addSql('ALTER TABLE destination ADD CONSTRAINT FK_3EC63EAA5DA1941 FOREIGN KEY (asset_id) REFERENCES asset (asset_id)');
        $this->addSql('ALTER TABLE entity_history ADD CONSTRAINT FK_B4774268A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F12469DE2 FOREIGN KEY (category_id) REFERENCES category (category_id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (vehicle_id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F59027487 FOREIGN KEY (theme_id) REFERENCES theme (theme_id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F3C8D39AA FOREIGN KEY (destination_start_id) REFERENCES destination (destination_id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FB0841587 FOREIGN KEY (destination_end_id) REFERENCES destination (destination_id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F4584665A FOREIGN KEY (product_id) REFERENCES product (product_id)');
        $this->addSql('ALTER TABLE package_guide ADD CONSTRAINT FK_5F9AC0D2D7ED1D4B FOREIGN KEY (guide_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE package_guide ADD CONSTRAINT FK_5F9AC0D2F44CABFF FOREIGN KEY (package_id) REFERENCES package (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE package_product ADD CONSTRAINT FK_5C1161214584665A FOREIGN KEY (product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE package_product ADD CONSTRAINT FK_5C116121F44CABFF FOREIGN KEY (package_id) REFERENCES package (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB6205DA1941 FOREIGN KEY (asset_id) REFERENCES asset (asset_id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62039FCA6F9 FOREIGN KEY (meta_id) REFERENCES meta (meta_id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (category_id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD39FCA6F9 FOREIGN KEY (meta_id) REFERENCES meta (meta_id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD816C6140 FOREIGN KEY (destination_id) REFERENCES destination (destination_id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD16F7E673 FOREIGN KEY (destination_from_id) REFERENCES destination (destination_id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADD62F4668 FOREIGN KEY (attached_file_id) REFERENCES asset (asset_id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD70C0C6E6 FOREIGN KEY (agency) REFERENCES agency (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_has_asset ADD CONSTRAINT FK_9786FC6F4584665A FOREIGN KEY (product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_has_asset ADD CONSTRAINT FK_9786FC6F5DA1941 FOREIGN KEY (asset_id) REFERENCES asset (asset_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_product ADD CONSTRAINT FK_EC53CE084584665A FOREIGN KEY (product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_product ADD CONSTRAINT FK_EC53CE08CF496EEA FOREIGN KEY (related_product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_in_month ADD CONSTRAINT FK_FF364EF4584665A FOREIGN KEY (product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_in_month ADD CONSTRAINT FK_FF364EFA0CBDE4 FOREIGN KEY (month_id) REFERENCES month (month_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_has_destination ADD CONSTRAINT FK_65ADBB304584665A FOREIGN KEY (product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_has_destination ADD CONSTRAINT FK_65ADBB30816C6140 FOREIGN KEY (destination_id) REFERENCES destination (destination_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_has_theme ADD CONSTRAINT FK_25C413B4584665A FOREIGN KEY (product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_has_theme ADD CONSTRAINT FK_25C413B59027487 FOREIGN KEY (theme_id) REFERENCES theme (theme_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_price ADD CONSTRAINT FK_6B9459854584665A FOREIGN KEY (product_id) REFERENCES product (product_id)');
        $this->addSql('ALTER TABLE product_price ADD CONSTRAINT FK_6B945985A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEFC4663E4 FOREIGN KEY (page_id) REFERENCES page (page_id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF5DA1941 FOREIGN KEY (asset_id) REFERENCES asset (asset_id)');
        $this->addSql('ALTER TABLE section_has_asset ADD CONSTRAINT FK_9B6B3A67D823E37A FOREIGN KEY (section_id) REFERENCES section (section_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section_has_asset ADD CONSTRAINT FK_9B6B3A675DA1941 FOREIGN KEY (asset_id) REFERENCES asset (asset_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section_has_product ADD CONSTRAINT FK_A24A1309D823E37A FOREIGN KEY (section_id) REFERENCES section (section_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section_has_product ADD CONSTRAINT FK_A24A13094584665A FOREIGN KEY (product_id) REFERENCES product (product_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section_has_theme ADD CONSTRAINT FK_EB18733D823E37A FOREIGN KEY (section_id) REFERENCES section (section_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section_has_theme ADD CONSTRAINT FK_EB1873359027487 FOREIGN KEY (theme_id) REFERENCES theme (theme_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section_has_destination ADD CONSTRAINT FK_C2A444A7D823E37A FOREIGN KEY (section_id) REFERENCES section (section_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section_has_destination ADD CONSTRAINT FK_C2A444A7816C6140 FOREIGN KEY (destination_id) REFERENCES destination (destination_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slider_has_asset ADD CONSTRAINT FK_B09013BB2CCC9638 FOREIGN KEY (slider_id) REFERENCES slider (slider_id)');
        $this->addSql('ALTER TABLE slider_has_asset ADD CONSTRAINT FK_B09013BB5DA1941 FOREIGN KEY (asset_id) REFERENCES asset (asset_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_has_asset ADD CONSTRAINT FK_37E5906F59027487 FOREIGN KEY (theme_id) REFERENCES theme (theme_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_has_asset ADD CONSTRAINT FK_37E5906F5DA1941 FOREIGN KEY (asset_id) REFERENCES asset (asset_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495DA1941 FOREIGN KEY (asset_id) REFERENCES asset (asset_id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64974468DA1 FOREIGN KEY (asset_identity_id) REFERENCES asset (asset_id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64973AC9AE0 FOREIGN KEY (asset_driver_license_id) REFERENCES asset (asset_id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64930E0B894 FOREIGN KEY (asset_medical_visit_id) REFERENCES asset (asset_id)');
        $this->addSql('ALTER TABLE user_agency ADD CONSTRAINT FK_1592DDDBCDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_agency ADD CONSTRAINT FK_1592DDDBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicle_has_asset ADD CONSTRAINT FK_E990FB0545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (vehicle_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicle_has_asset ADD CONSTRAINT FK_E990FB05DA1941 FOREIGN KEY (asset_id) REFERENCES asset (asset_id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agency DROP FOREIGN KEY FK_70C0C6E61D1C63B3');
        $this->addSql('ALTER TABLE agency DROP FOREIGN KEY FK_70C0C6E68BAC62AF');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE19EB6921');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEF44CABFF');
        $this->addSql('ALTER TABLE booking_guide DROP FOREIGN KEY FK_5BE23A80D7ED1D4B');
        $this->addSql('ALTER TABLE booking_guide DROP FOREIGN KEY FK_5BE23A803301C60');
        $this->addSql('ALTER TABLE booking_product DROP FOREIGN KEY FK_89F4418D4584665A');
        $this->addSql('ALTER TABLE booking_product DROP FOREIGN KEY FK_89F4418D3301C60');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C19361974C');
        $this->addSql('ALTER TABLE custom_property DROP FOREIGN KEY FK_6E20FBBA4584665A');
        $this->addSql('ALTER TABLE custom_property DROP FOREIGN KEY FK_6E20FBBAA76ED395');
        $this->addSql('ALTER TABLE destination DROP FOREIGN KEY FK_3EC63EAA377476D9');
        $this->addSql('ALTER TABLE destination DROP FOREIGN KEY FK_3EC63EAA3A80E84A');
        $this->addSql('ALTER TABLE destination DROP FOREIGN KEY FK_3EC63EAA5DA1941');
        $this->addSql('ALTER TABLE entity_history DROP FOREIGN KEY FK_B4774268A76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F12469DE2');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F545317D1');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F59027487');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F3C8D39AA');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FB0841587');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F4584665A');
        $this->addSql('ALTER TABLE package_guide DROP FOREIGN KEY FK_5F9AC0D2D7ED1D4B');
        $this->addSql('ALTER TABLE package_guide DROP FOREIGN KEY FK_5F9AC0D2F44CABFF');
        $this->addSql('ALTER TABLE package_product DROP FOREIGN KEY FK_5C1161214584665A');
        $this->addSql('ALTER TABLE package_product DROP FOREIGN KEY FK_5C116121F44CABFF');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB6205DA1941');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62039FCA6F9');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD39FCA6F9');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD816C6140');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD16F7E673');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADD62F4668');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD70C0C6E6');
        $this->addSql('ALTER TABLE product_has_asset DROP FOREIGN KEY FK_9786FC6F4584665A');
        $this->addSql('ALTER TABLE product_has_asset DROP FOREIGN KEY FK_9786FC6F5DA1941');
        $this->addSql('ALTER TABLE related_product DROP FOREIGN KEY FK_EC53CE084584665A');
        $this->addSql('ALTER TABLE related_product DROP FOREIGN KEY FK_EC53CE08CF496EEA');
        $this->addSql('ALTER TABLE product_in_month DROP FOREIGN KEY FK_FF364EF4584665A');
        $this->addSql('ALTER TABLE product_in_month DROP FOREIGN KEY FK_FF364EFA0CBDE4');
        $this->addSql('ALTER TABLE product_has_destination DROP FOREIGN KEY FK_65ADBB304584665A');
        $this->addSql('ALTER TABLE product_has_destination DROP FOREIGN KEY FK_65ADBB30816C6140');
        $this->addSql('ALTER TABLE product_has_theme DROP FOREIGN KEY FK_25C413B4584665A');
        $this->addSql('ALTER TABLE product_has_theme DROP FOREIGN KEY FK_25C413B59027487');
        $this->addSql('ALTER TABLE product_price DROP FOREIGN KEY FK_6B9459854584665A');
        $this->addSql('ALTER TABLE product_price DROP FOREIGN KEY FK_6B945985A76ED395');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEFC4663E4');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF5DA1941');
        $this->addSql('ALTER TABLE section_has_asset DROP FOREIGN KEY FK_9B6B3A67D823E37A');
        $this->addSql('ALTER TABLE section_has_asset DROP FOREIGN KEY FK_9B6B3A675DA1941');
        $this->addSql('ALTER TABLE section_has_product DROP FOREIGN KEY FK_A24A1309D823E37A');
        $this->addSql('ALTER TABLE section_has_product DROP FOREIGN KEY FK_A24A13094584665A');
        $this->addSql('ALTER TABLE section_has_theme DROP FOREIGN KEY FK_EB18733D823E37A');
        $this->addSql('ALTER TABLE section_has_theme DROP FOREIGN KEY FK_EB1873359027487');
        $this->addSql('ALTER TABLE section_has_destination DROP FOREIGN KEY FK_C2A444A7D823E37A');
        $this->addSql('ALTER TABLE section_has_destination DROP FOREIGN KEY FK_C2A444A7816C6140');
        $this->addSql('ALTER TABLE slider_has_asset DROP FOREIGN KEY FK_B09013BB2CCC9638');
        $this->addSql('ALTER TABLE slider_has_asset DROP FOREIGN KEY FK_B09013BB5DA1941');
        $this->addSql('ALTER TABLE theme_has_asset DROP FOREIGN KEY FK_37E5906F59027487');
        $this->addSql('ALTER TABLE theme_has_asset DROP FOREIGN KEY FK_37E5906F5DA1941');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495DA1941');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64974468DA1');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64973AC9AE0');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64930E0B894');
        $this->addSql('ALTER TABLE user_agency DROP FOREIGN KEY FK_1592DDDBCDEADB2A');
        $this->addSql('ALTER TABLE user_agency DROP FOREIGN KEY FK_1592DDDBA76ED395');
        $this->addSql('ALTER TABLE vehicle_has_asset DROP FOREIGN KEY FK_E990FB0545317D1');
        $this->addSql('ALTER TABLE vehicle_has_asset DROP FOREIGN KEY FK_E990FB05DA1941');
        $this->addSql('DROP TABLE agency');
        $this->addSql('DROP TABLE asset');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_guide');
        $this->addSql('DROP TABLE booking_product');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE custom_property');
        $this->addSql('DROP TABLE destination');
        $this->addSql('DROP TABLE entity_history');
        $this->addSql('DROP TABLE ext_translations_element');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE meta');
        $this->addSql('DROP TABLE month');
        $this->addSql('DROP TABLE package');
        $this->addSql('DROP TABLE package_guide');
        $this->addSql('DROP TABLE package_product');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_has_asset');
        $this->addSql('DROP TABLE related_product');
        $this->addSql('DROP TABLE product_in_month');
        $this->addSql('DROP TABLE product_has_destination');
        $this->addSql('DROP TABLE product_has_theme');
        $this->addSql('DROP TABLE product_price');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE section_has_asset');
        $this->addSql('DROP TABLE section_has_product');
        $this->addSql('DROP TABLE section_has_theme');
        $this->addSql('DROP TABLE section_has_destination');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE slider');
        $this->addSql('DROP TABLE slider_has_asset');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE theme_has_asset');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_agency');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE vehicle_has_asset');
    }
}
