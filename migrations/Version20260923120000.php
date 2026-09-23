<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Jeu de données de démonstration pour ExcursionMaroc : catégories,
 * destinations, agences (dont une en attente de validation), excursions
 * (dont une en attente de modération et une refusée), réservations, avis
 * et favoris. Permet de visualiser une marketplace complète sans passer
 * par toute la saisie manuelle.
 *
 * Purement additive et idempotente (skip si déjà appliquée) : ne touche à
 * aucune donnée existante.
 */
final class Version20260923120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Jeu de données de démonstration (catégories, destinations, agences, excursions, réservations, avis)';
    }

    public function up(Schema $schema): void
    {
        $alreadySeeded = (int) $this->connection->fetchOne(
            "SELECT COUNT(*) FROM agency WHERE slug = 'atlas-adventures'"
        );
        $alreadyConfigured = (int) $this->connection->fetchOne(
            "SELECT COUNT(*) FROM settings WHERE `key` = 'application_name'"
        );
        $this->skipIf($alreadySeeded > 0, 'Demo data already seeded.');
        $this->skipIf($alreadyConfigured > 0, 'Application settings already configured, skipping demo data to avoid overwriting a real site.');

        // ===== SETTINGS =====
        $this->addSql('INSERT INTO settings (`key`, `value`) VALUES (\'application_name\', \'ExcursionMaroc\');');
        $this->addSql('INSERT INTO settings (`key`, `value`) VALUES (\'application_about\', \'ExcursionMaroc.com met en relation les voyageurs avec des agences locales certifiees partout au Maroc. Reservez des excursions, circuits et activites en toute simplicite, sans commission.\');');
        $this->addSql('INSERT INTO settings (`key`, `value`) VALUES (\'application_description\', \'Marketplace d\\\'excursions et de circuits au Maroc : reservez en ligne aupres d\\\'agences locales verifiees, sans commission.\');');
        $this->addSql('INSERT INTO settings (`key`, `value`) VALUES (\'application_email\', \'contact@excursionmaroc.com\');');
        $this->addSql('INSERT INTO settings (`key`, `value`) VALUES (\'application_phone\', \'+212 5 24 00 00 00\');');
        $this->addSql('INSERT INTO settings (`key`, `value`) VALUES (\'application_address\', \'Guéliz, Marrakech, Maroc\');');
        $this->addSql('
-- ===== USERS =====');
        $this->addSql('INSERT INTO user (email, roles, password, enabled, user_first_name, user_last_name, user_phone, user_country, user_language) VALUES (\'admin@excursionmaroc.com\', \'[\\"ROLE_ADMIN\\"]\', \'$2y$12$ZuskcMaOPlAgVZiiQabthekcNGrgwcTd9KHWp9zFfBgaEZ9H0cc9a\', 1, \'Yassine\', \'Alaoui\', \'+212600000001\', \'Morocco\', \'fr\');');
        $this->addSql('SET @user_admin := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user (email, roles, password, enabled, user_first_name, user_last_name, user_phone, user_country, user_language) VALUES (\'contact@atlas-adventures.ma\', \'[\\"ROLE_AGENCY\\"]\', \'$2y$12$ZuskcMaOPlAgVZiiQabthekcNGrgwcTd9KHWp9zFfBgaEZ9H0cc9a\', 1, \'Karim\', \'Benjelloun\', \'+212600000010\', \'Morocco\', \'fr\');');
        $this->addSql('SET @user_owner_atlas := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user (email, roles, password, enabled, user_first_name, user_last_name, user_phone, user_country, user_language) VALUES (\'contact@sahara-desert-tours.ma\', \'[\\"ROLE_AGENCY\\"]\', \'$2y$12$ZuskcMaOPlAgVZiiQabthekcNGrgwcTd9KHWp9zFfBgaEZ9H0cc9a\', 1, \'Fatima\', \'Ouahbi\', \'+212600000011\', \'Morocco\', \'fr\');');
        $this->addSql('SET @user_owner_sahara := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user (email, roles, password, enabled, user_first_name, user_last_name, user_phone, user_country, user_language) VALUES (\'contact@bluepearltravel.ma\', \'[\\"ROLE_AGENCY\\"]\', \'$2y$12$ZuskcMaOPlAgVZiiQabthekcNGrgwcTd9KHWp9zFfBgaEZ9H0cc9a\', 1, \'Hassan\', \'Ziani\', \'+212600000012\', \'Morocco\', \'fr\');');
        $this->addSql('SET @user_owner_bluepearl := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user (email, roles, password, enabled, user_first_name, user_last_name, user_phone, user_country, user_language) VALUES (\'contact@atlanticcoast.ma\', \'[\\"ROLE_AGENCY\\"]\', \'$2y$12$ZuskcMaOPlAgVZiiQabthekcNGrgwcTd9KHWp9zFfBgaEZ9H0cc9a\', 1, \'Laila\', \'Mansouri\', \'+212600000013\', \'Morocco\', \'fr\');');
        $this->addSql('SET @user_owner_atlantic := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user (email, roles, password, enabled, user_first_name, user_last_name, user_phone, user_country, user_language) VALUES (\'contact@imperialcities.ma\', \'[\\"ROLE_AGENCY\\"]\', \'$2y$12$ZuskcMaOPlAgVZiiQabthekcNGrgwcTd9KHWp9zFfBgaEZ9H0cc9a\', 1, \'Omar\', \'Cherkaoui\', \'+212600000014\', \'Morocco\', \'fr\');');
        $this->addSql('SET @user_owner_imperial := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user (email, roles, password, enabled, user_first_name, user_last_name, user_phone, user_country, user_language) VALUES (\'contact@desertnomads.ma\', \'[\\"ROLE_AGENCY\\"]\', \'$2y$12$ZuskcMaOPlAgVZiiQabthekcNGrgwcTd9KHWp9zFfBgaEZ9H0cc9a\', 1, \'Rachid\', \'Boukhris\', \'+212600000015\', \'Morocco\', \'fr\');');
        $this->addSql('SET @user_owner_nomads := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user (email, roles, password, enabled, user_first_name, user_last_name, user_phone, user_country, user_language) VALUES (\'sara.amrani@example.com\', \'[\\"ROLE_USER\\"]\', \'$2y$12$ZuskcMaOPlAgVZiiQabthekcNGrgwcTd9KHWp9zFfBgaEZ9H0cc9a\', 1, \'Sara\', \'Amrani\', \'+212600000020\', \'Morocco\', \'fr\');');
        $this->addSql('SET @user_client1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user (email, roles, password, enabled, user_first_name, user_last_name, user_phone, user_country, user_language) VALUES (\'youssef.elidrissi@example.com\', \'[\\"ROLE_USER\\"]\', \'$2y$12$ZuskcMaOPlAgVZiiQabthekcNGrgwcTd9KHWp9zFfBgaEZ9H0cc9a\', 1, \'Youssef\', \'El Idrissi\', \'+33600000021\', \'Morocco\', \'fr\');');
        $this->addSql('SET @user_client2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user (email, roles, password, enabled, user_first_name, user_last_name, user_phone, user_country, user_language) VALUES (\'nadia.bensouda@example.com\', \'[\\"ROLE_USER\\"]\', \'$2y$12$ZuskcMaOPlAgVZiiQabthekcNGrgwcTd9KHWp9zFfBgaEZ9H0cc9a\', 1, \'Nadia\', \'Bensouda\', \'+212600000022\', \'Morocco\', \'fr\');');
        $this->addSql('SET @user_client3 := LAST_INSERT_ID();');
        $this->addSql('
-- ===== CATEGORIES =====');
        $this->addSql('INSERT INTO category (category_name, category_slug, category_short_description) VALUES (\'Excursions à la journée\', \'excursions-journee\', \'Decouvrez le Maroc le temps d\\\'une journee : sites naturels, villes imperiales et experiences locales a proximite de votre lieu de sejour.\');');
        $this->addSql('SET @cat_journee := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO category (category_name, category_slug, category_short_description) VALUES (\'Circuits multi-jours\', \'circuits-multi-jours\', \'Des circuits de plusieurs jours a travers les plus belles regions du Maroc, hebergement et transport inclus.\');');
        $this->addSql('SET @cat_circuits := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO category (category_name, category_slug, category_short_description) VALUES (\'Désert & Sahara\', \'desert-sahara\', \'Bivouacs, nuits sous les etoiles et randonnees chamelieres dans les dunes de Merzouga et Zagora.\');');
        $this->addSql('SET @cat_desert := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO category (category_name, category_slug, category_short_description) VALUES (\'Randonnée & Trek\', \'randonnee-trek\', \'Randonnees guidees dans l\\\'Atlas et les vallees du Maroc, pour tous les niveaux.\');');
        $this->addSql('SET @cat_trek := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO category (category_name, category_slug, category_short_description) VALUES (\'Activités nautiques\', \'activites-nautiques\', \'Surf, kitesurf et sorties en mer sur la cote atlantique.\');');
        $this->addSql('SET @cat_nautique := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO category (category_name, category_slug, category_short_description) VALUES (\'Transferts aéroport\', \'transferts-aeroport\', \'Transferts prives entre aeroports, gares et hebergements.\');');
        $this->addSql('SET @cat_transfert := LAST_INSERT_ID();');
        $this->addSql('
-- ===== DESTINATIONS =====');
        $this->addSql('INSERT INTO destination (destination_name, destination_slug) VALUES (\'Marrakech\', \'marrakech\');');
        $this->addSql('SET @dest_marrakech := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO destination (destination_name, destination_slug) VALUES (\'Fès\', \'fes\');');
        $this->addSql('SET @dest_fes := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO destination (destination_name, destination_slug) VALUES (\'Chefchaouen\', \'chefchaouen\');');
        $this->addSql('SET @dest_chefchaouen := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO destination (destination_name, destination_slug) VALUES (\'Essaouira\', \'essaouira\');');
        $this->addSql('SET @dest_essaouira := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO destination (destination_name, destination_slug) VALUES (\'Agadir\', \'agadir\');');
        $this->addSql('SET @dest_agadir := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO destination (destination_name, destination_slug) VALUES (\'Ouarzazate\', \'ouarzazate\');');
        $this->addSql('SET @dest_ouarzazate := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO destination (destination_name, destination_slug) VALUES (\'Merzouga\', \'merzouga\');');
        $this->addSql('SET @dest_merzouga := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO destination (destination_name, destination_slug) VALUES (\'Casablanca\', \'casablanca\');');
        $this->addSql('SET @dest_casablanca := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO destination (destination_name, destination_slug) VALUES (\'Rabat\', \'rabat\');');
        $this->addSql('SET @dest_rabat := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO destination (destination_name, destination_slug) VALUES (\'Tanger\', \'tanger\');');
        $this->addSql('SET @dest_tanger := LAST_INSERT_ID();');
        $this->addSql('
-- ===== AGENCIES =====');
        $this->addSql('INSERT INTO agency (utilisateur, name, slug, email, phone, short_description, long_description, valid, verified, years_experience, logo, country, date_create) VALUES (@user_owner_atlas, \'Atlas Adventures\', \'atlas-adventures\', \'contact@atlas-adventures.ma\', \'+212524000010\', \'Specialiste des excursions et randonnees dans le Haut Atlas depuis Marrakech.\', \'Atlas Adventures est une agence marocaine basee a Marrakech, specialisee dans les excursions a la journee et les treks dans le Haut Atlas. Notre equipe de guides locaux vous fait decouvrir les vallees, cascades et villages berberes en toute securite.\', 1, 1, 12, \'atlas-adventures.jpg\', \'Maroc\', NOW());');
        $this->addSql('SET @agency_atlas := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user_agency (agency_id, user_id, role) VALUES (@agency_atlas, @user_owner_atlas, \'owner\');');
        $this->addSql('INSERT INTO agency (utilisateur, name, slug, email, phone, short_description, long_description, valid, verified, years_experience, logo, country, date_create) VALUES (@user_owner_sahara, \'Sahara Desert Tours\', \'sahara-desert-tours\', \'contact@sahara-desert-tours.ma\', \'+212535000011\', \'Bivouacs et circuits dans le desert de Merzouga depuis plus de 10 ans.\', \'Sahara Desert Tours organise des nuits en bivouac, des balades a dos de chameau et des circuits 4x4 dans les dunes de l\\\'Erg Chebbi. Une equipe locale, nee et elevee aux portes du desert.\', 1, 1, 15, \'sahara-desert-tours.jpg\', \'Maroc\', NOW());');
        $this->addSql('SET @agency_sahara := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user_agency (agency_id, user_id, role) VALUES (@agency_sahara, @user_owner_sahara, \'owner\');');
        $this->addSql('INSERT INTO agency (utilisateur, name, slug, email, phone, short_description, long_description, valid, verified, years_experience, logo, country, date_create) VALUES (@user_owner_bluepearl, \'Blue Pearl Travel\', \'blue-pearl-travel\', \'contact@bluepearltravel.ma\', \'+212539000012\', \'Visites guidees de la ville bleue et randonnees dans le Rif.\', \'Blue Pearl Travel fait decouvrir Chefchaouen et ses environs : medina bleue, cascades d\\\'Akchour et villages du Rif, avec des guides passionnes par leur region.\', 1, 0, 5, \'blue-pearl-travel.jpg\', \'Maroc\', NOW());');
        $this->addSql('SET @agency_bluepearl := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user_agency (agency_id, user_id, role) VALUES (@agency_bluepearl, @user_owner_bluepearl, \'owner\');');
        $this->addSql('INSERT INTO agency (utilisateur, name, slug, email, phone, short_description, long_description, valid, verified, years_experience, logo, country, date_create) VALUES (@user_owner_atlantic, \'Atlantic Coast Excursions\', \'atlantic-coast-excursions\', \'contact@atlanticcoast.ma\', \'+212524000013\', \'Surf, kitesurf et activites nautiques sur la cote d\\\'Essaouira.\', \'Atlantic Coast Excursions propose des cours de surf, du kitesurf et des sorties en quad sur la plage d\\\'Essaouira, encadres par des moniteurs diplomes.\', 1, 1, 8, \'atlantic-coast-excursions.jpg\', \'Maroc\', NOW());');
        $this->addSql('SET @agency_atlantic := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user_agency (agency_id, user_id, role) VALUES (@agency_atlantic, @user_owner_atlantic, \'owner\');');
        $this->addSql('INSERT INTO agency (utilisateur, name, slug, email, phone, short_description, long_description, valid, verified, years_experience, logo, country, date_create) VALUES (@user_owner_imperial, \'Imperial Cities Voyages\', \'imperial-cities-voyages\', \'contact@imperialcities.ma\', \'+212535000014\', \'Circuits et visites guidees des villes imperiales du Maroc.\', \'Imperial Cities Voyages est specialiste des circuits culturels entre Fes, Meknes, Rabat et Marrakech, avec des guides agrees par le ministere du Tourisme.\', 1, 1, 20, \'imperial-cities-voyages.jpg\', \'Maroc\', NOW());');
        $this->addSql('SET @agency_imperial := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user_agency (agency_id, user_id, role) VALUES (@agency_imperial, @user_owner_imperial, \'owner\');');
        $this->addSql('INSERT INTO agency (utilisateur, name, slug, email, phone, short_description, long_description, valid, verified, years_experience, logo, country, date_create) VALUES (@user_owner_nomads, \'Desert Nomads Expeditions\', \'desert-nomads-expeditions\', \'contact@desertnomads.ma\', \'+212524000015\', \'Nouvelle agence basee a Ouarzazate, en cours de validation.\', \'Desert Nomads Expeditions est une jeune agence basee a Ouarzazate, specialisee dans les visites des studios de cinema et les circuits vers la vallee du Draa. Compte en attente de validation par l\\\'equipe ExcursionMaroc.\', 0, 0, 2, NULL, \'Maroc\', NOW());');
        $this->addSql('SET @agency_nomads := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO user_agency (agency_id, user_id, role) VALUES (@agency_nomads, @user_owner_nomads, \'owner\');');
        $this->addSql('
-- ===== PRODUCTS =====');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_atlas, @cat_journee, @dest_marrakech, \'Excursion Vallée de l\\\'Ourika & Cascades\', \'excursion-vallee-ourika-cascades\', \'Journee complete dans la vallee de l\\\'Ourika : marche jusqu\\\'aux cascades de Setti Fatma et dejeuner berbere.\', \'Depart le matin de Marrakech en direction de la vallee de l\\\'Ourika, au pied du Haut Atlas. Arret dans les villages berberes, decouverte des cascades de Setti Fatma (marche d\\\'environ 1h30) et dejeuner traditionnel chez l\\\'habitant. Retour a Marrakech en fin de journee.\', 350, 1, 15, \'Transport climatise, guide francophone, dejeuner berbere\', \'Boissons, pourboires\', \'Jemaa el-Fna, devant la pharmacie centrale\', \'08:30\', \'18:00\', \'1 jour\', \'Facile\', 1, 1, 1, 0, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 35 DAY));');
        $this->addSql('SET @product_ourika := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_ourika, @dest_marrakech);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'atlas.jpg\', \'Excursion Vallée de l\\\'Ourika & Cascades\');');
        $this->addSql('SET @asset_ourika_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_ourika, @asset_ourika_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_ourika, \'atlas-2.jpg\', \'Excursion Vallée de l\\\'Ourika & Cascades\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'mountains.jpg\', \'Excursion Vallée de l\\\'Ourika & Cascades\');');
        $this->addSql('SET @asset_ourika_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_ourika, @asset_ourika_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_ourika, \'mountains-2.jpg\', \'Excursion Vallée de l\\\'Ourika & Cascades\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_atlas, @cat_trek, @dest_marrakech, \'Trek Vallée des Roses & Atlas\', \'trek-vallee-des-roses-atlas\', \'Randonnee de 2 jours dans la Vallee des Roses avec nuit en gite berbere.\', \'Un trek de deux jours a travers la Vallee des Roses, celebre pour ses champs de roses de Damas et ses villages en pise. Nuit en gite d\\\'etape chez l\\\'habitant, repas locaux inclus. Ideal pour les amateurs de randonnee et de rencontres authentiques.\', 650, 2, 10, \'Transport, guide de montagne, hebergement en gite, pension complete\', \'Assurance voyage, materiel de trek personnel\', \'Place Jemaa el-Fna, Marrakech\', \'07:00\', \'19:00 (J+1)\', \'2 jours\', \'Modéré\', 1, 1, 1, 0, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 20 DAY));');
        $this->addSql('SET @product_roses := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_roses, @dest_marrakech);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'mountains.jpg\', \'Trek Vallée des Roses & Atlas\');');
        $this->addSql('SET @asset_roses_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_roses, @asset_roses_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_roses, \'mountains-2.jpg\', \'Trek Vallée des Roses & Atlas\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'garden.jpg\', \'Trek Vallée des Roses & Atlas\');');
        $this->addSql('SET @asset_roses_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_roses, @asset_roses_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_roses, \'garden-2.jpg\', \'Trek Vallée des Roses & Atlas\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_atlas, @cat_journee, @dest_marrakech, \'Excursion Cascades d\\\'Ouzoud\', \'excursion-cascades-ouzoud\', \'Journee aux cascades d\\\'Ouzoud, les plus hautes chutes d\\\'eau du Maroc du Nord.\', \'Visite des cascades d\\\'Ouzoud, hautes de plus de 100 metres. Promenade dans les oliveraies, observation des singes magots, possibilite de baignade en ete et balade en barque au pied des chutes.\', 300, 1, 20, \'Transport climatise, guide francophone\', \'Dejeuner, baignade et activites optionnelles\', \'Jemaa el-Fna, devant la pharmacie centrale\', \'08:00\', \'18:30\', \'1 jour\', \'Facile\', 1, 1, 0, 0, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 40 DAY));');
        $this->addSql('SET @product_ouzoud := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_ouzoud, @dest_marrakech);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'garden.jpg\', \'Excursion Cascades d\\\'Ouzoud\');');
        $this->addSql('SET @asset_ouzoud_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_ouzoud, @asset_ouzoud_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_ouzoud, \'garden-2.jpg\', \'Excursion Cascades d\\\'Ouzoud\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'mountains.jpg\', \'Excursion Cascades d\\\'Ouzoud\');');
        $this->addSql('SET @asset_ouzoud_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_ouzoud, @asset_ouzoud_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_ouzoud, \'mountains-2.jpg\', \'Excursion Cascades d\\\'Ouzoud\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_atlas, @cat_circuits, @dest_marrakech, \'Circuit 3 jours Marrakech - Désert de Merzouga\', \'circuit-3-jours-marrakech-desert-merzouga\', \'Circuit de 3 jours entre Marrakech et les dunes de Merzouga via la vallee du Dades.\', \'Un grand classique : traversee du col du Tichka, visite d\\\'Ait Ben Haddou, nuit a Dades, puis route vers Merzouga pour une nuit en bivouac dans le desert avec balade a dos de chameau. Retour a Marrakech le 3e jour.\', 1800, 2, 8, \'Transport 4x4, chauffeur-guide, 2 nuits (hotel + bivouac), petit-dejeuner et diners\', \'Dejeuners, boissons, activites optionnelles\', \'Votre hotel a Marrakech\', \'07:00\', \'Jour 3, 20:00\', \'3 jours / 2 nuits\', \'Modéré\', 1, 1, 1, 0, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 15 DAY));');
        $this->addSql('SET @product_circuit3j := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_circuit3j, @dest_marrakech);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'kasbah.jpg\', \'Circuit 3 jours Marrakech - Désert de Merzouga\');');
        $this->addSql('SET @asset_circuit3j_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_circuit3j, @asset_circuit3j_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_circuit3j, \'kasbah-2.jpg\', \'Circuit 3 jours Marrakech - Désert de Merzouga\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'sahara.jpg\', \'Circuit 3 jours Marrakech - Désert de Merzouga\');');
        $this->addSql('SET @asset_circuit3j_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_circuit3j, @asset_circuit3j_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_circuit3j, \'sahara-2.jpg\', \'Circuit 3 jours Marrakech - Désert de Merzouga\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_sahara, @cat_desert, @dest_merzouga, \'Nuit dans le désert de Merzouga en bivouac\', \'nuit-desert-merzouga-bivouac\', \'Nuit inoubliable en bivouac de luxe dans les dunes de l\\\'Erg Chebbi.\', \'Balade a dos de chameau au coucher du soleil jusqu\\\'au bivouac install dans les dunes de l\\\'Erg Chebbi. Diner traditionnel autour du feu, musique gnaoua, nuit sous les etoiles et petit-dejeuner face au lever du soleil sur les dunes.\', 450, 1, 12, \'Chameau, bivouac, diner et petit-dejeuner, feu de camp\', \'Transport depuis votre ville, boissons alcoolisees\', \'Camp de base Erg Chebbi, Merzouga\', \'17:00\', \'Lendemain 09:00\', \'1 nuit\', \'Facile\', 0, 1, 1, 0, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 30 DAY));');
        $this->addSql('SET @product_bivouac := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_bivouac, @dest_merzouga);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'sahara.jpg\', \'Nuit dans le désert de Merzouga en bivouac\');');
        $this->addSql('SET @asset_bivouac_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_bivouac, @asset_bivouac_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_bivouac, \'sahara-2.jpg\', \'Nuit dans le désert de Merzouga en bivouac\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'dunes.jpg\', \'Nuit dans le désert de Merzouga en bivouac\');');
        $this->addSql('SET @asset_bivouac_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_bivouac, @asset_bivouac_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_bivouac, \'dunes-2.jpg\', \'Nuit dans le désert de Merzouga en bivouac\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_sahara, @cat_desert, @dest_merzouga, \'Balade à dos de chameau au coucher du soleil\', \'balade-chameau-coucher-soleil\', \'Courte balade a dos de chameau dans les dunes au coucher du soleil.\', \'Une balade d\\\'environ 2 heures a dos de dromadaire dans les dunes de l\\\'Erg Chebbi, ideale pour admirer le coucher du soleil sur le desert. Accompagnement par un chamelier local.\', 200, 1, 20, \'Chameau, chamelier, the a la menthe\', \'Transport, repas\', \'Camp de base Erg Chebbi, Merzouga\', \'17:30\', \'19:30\', \'2 heures\', \'Facile\', 0, 1, 0, 0, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 25 DAY));');
        $this->addSql('SET @product_chameau := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_chameau, @dest_merzouga);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'dunes.jpg\', \'Balade à dos de chameau au coucher du soleil\');');
        $this->addSql('SET @asset_chameau_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_chameau, @asset_chameau_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_chameau, \'dunes-2.jpg\', \'Balade à dos de chameau au coucher du soleil\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'sahara.jpg\', \'Balade à dos de chameau au coucher du soleil\');');
        $this->addSql('SET @asset_chameau_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_chameau, @asset_chameau_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_chameau, \'sahara-2.jpg\', \'Balade à dos de chameau au coucher du soleil\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_sahara, @cat_desert, @dest_merzouga, \'Circuit 4x4 Erg Chebbi\', \'circuit-4x4-erg-chebbi\', \'Excursion en 4x4 a travers les dunes et oasis autour de Merzouga.\', \'Une demi-journee en 4x4 a la decouverte des paysages autour de Merzouga : lac Dayet Srji (selon saison), village de nomades, oasis de Khamlia et musique locale gnaoua.\', 550, 2, 6, \'Vehicule 4x4, chauffeur-guide, the a la menthe\', \'Dejeuner, pourboires\', \'Camp de base Erg Chebbi, Merzouga\', \'09:00\', \'13:00\', \'4 heures\', \'Facile\', 1, 1, 0, 1, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 12 DAY));');
        $this->addSql('SET @product_x4erg := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_x4erg, @dest_merzouga);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'dunes.jpg\', \'Circuit 4x4 Erg Chebbi\');');
        $this->addSql('SET @asset_x4erg_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_x4erg, @asset_x4erg_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_x4erg, \'dunes-2.jpg\', \'Circuit 4x4 Erg Chebbi\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'kasbah.jpg\', \'Circuit 4x4 Erg Chebbi\');');
        $this->addSql('SET @asset_x4erg_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_x4erg, @asset_x4erg_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_x4erg, \'kasbah-2.jpg\', \'Circuit 4x4 Erg Chebbi\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_bluepearl, @cat_journee, @dest_chefchaouen, \'Visite guidée de la médina bleue\', \'visite-guidee-medina-bleue-chefchaouen\', \'Decouverte a pied des ruelles bleues de Chefchaouen avec un guide local.\', \'Balade guidee dans la medina de Chefchaouen : places typiques, ateliers d\\\'artisans, points de vue sur la ville bleue et la Kasbah. Une immersion dans l\\\'une des villes les plus photogeniques du Maroc.\', 150, 1, 15, \'Guide local francophone\', \'Achats, boissons, entrees des musees\', \'Place Outa el Hammam, Chefchaouen\', \'10:00\', \'12:30\', \'2h30\', \'Facile\', 0, 1, 0, 0, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 18 DAY));');
        $this->addSql('SET @product_medina_chef := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_medina_chef, @dest_chefchaouen);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'blue-city.jpg\', \'Visite guidée de la médina bleue\');');
        $this->addSql('SET @asset_medina_chef_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_medina_chef, @asset_medina_chef_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_medina_chef, \'blue-city-2.jpg\', \'Visite guidée de la médina bleue\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'medina.jpg\', \'Visite guidée de la médina bleue\');');
        $this->addSql('SET @asset_medina_chef_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_medina_chef, @asset_medina_chef_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_medina_chef, \'medina-2.jpg\', \'Visite guidée de la médina bleue\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_bluepearl, @cat_trek, @dest_chefchaouen, \'Randonnée Cascade d\\\'Akchour\', \'randonnee-cascade-akchour\', \'Randonnee jusqu\\\'aux cascades d\\\'Akchour et au Pont de Dieu.\', \'Randonnee dans le Parc National de Talassemtane, le long de la riviere jusqu\\\'aux cascades d\\\'Akchour puis, pour les plus courageux, jusqu\\\'au Pont de Dieu, une arche rocheuse naturelle spectaculaire.\', 250, 1, 12, \'Transport, guide de randonnee\', \'Dejeuner, baignade\', \'Place Outa el Hammam, Chefchaouen\', \'08:00\', \'16:00\', \'1 jour\', \'Modéré\', 1, 1, 0, 0, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 22 DAY));');
        $this->addSql('SET @product_akchour := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_akchour, @dest_chefchaouen);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'mountains.jpg\', \'Randonnée Cascade d\\\'Akchour\');');
        $this->addSql('SET @asset_akchour_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_akchour, @asset_akchour_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_akchour, \'mountains-2.jpg\', \'Randonnée Cascade d\\\'Akchour\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'blue-city.jpg\', \'Randonnée Cascade d\\\'Akchour\');');
        $this->addSql('SET @asset_akchour_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_akchour, @asset_akchour_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_akchour, \'blue-city-2.jpg\', \'Randonnée Cascade d\\\'Akchour\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_bluepearl, @cat_journee, @dest_tanger, \'Excursion Chefchaouen depuis Tanger\', \'excursion-chefchaouen-depuis-tanger\', \'Journee decouverte de Chefchaouen au depart de Tanger.\', \'Depart de Tanger vers Chefchaouen a travers les paysages du Rif. Temps libre dans la medina bleue, visite guidee optionnelle et retour en fin d\\\'apres-midi.\', 400, 1, 16, \'Transport climatise, guide francophone\', \'Dejeuner, entrees\', \'Votre hotel a Tanger\', \'08:00\', \'19:00\', \'1 jour\', \'Facile\', 1, 1, 0, 0, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 28 DAY));');
        $this->addSql('SET @product_chef_tanger := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_chef_tanger, @dest_tanger);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'blue-city.jpg\', \'Excursion Chefchaouen depuis Tanger\');');
        $this->addSql('SET @asset_chef_tanger_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_chef_tanger, @asset_chef_tanger_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_chef_tanger, \'blue-city-2.jpg\', \'Excursion Chefchaouen depuis Tanger\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'ocean.jpg\', \'Excursion Chefchaouen depuis Tanger\');');
        $this->addSql('SET @asset_chef_tanger_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_chef_tanger, @asset_chef_tanger_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_chef_tanger, \'ocean-2.jpg\', \'Excursion Chefchaouen depuis Tanger\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_atlantic, @cat_nautique, @dest_essaouira, \'Cours de surf à Essaouira\', \'cours-surf-essaouira\', \'Cours de surf pour debutants encadre par un moniteur diplome.\', \'Cours collectif de surf sur la plage d\\\'Essaouira, reputee pour ses vagues regulieres. Materiel fourni, encadrement par des moniteurs diplomes d\\\'Etat, adapte aux debutants comme aux niveaux intermediaires.\', 300, 1, 8, \'Combinaison, planche, moniteur diplome\', \'Transport, assurance\', \'Poste de secours, plage d\\\'Essaouira\', \'09:00\', \'11:00\', \'2 heures\', \'Facile\', 0, 1, 0, 0, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 10 DAY));');
        $this->addSql('SET @product_surf := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_surf, @dest_essaouira);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'ocean.jpg\', \'Cours de surf à Essaouira\');');
        $this->addSql('SET @asset_surf_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_surf, @asset_surf_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_surf, \'ocean-2.jpg\', \'Cours de surf à Essaouira\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'coast.jpg\', \'Cours de surf à Essaouira\');');
        $this->addSql('SET @asset_surf_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_surf, @asset_surf_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_surf, \'coast-2.jpg\', \'Cours de surf à Essaouira\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_atlantic, @cat_nautique, @dest_essaouira, \'Balade en quad sur la plage\', \'balade-quad-plage-essaouira\', \'Balade en quad le long de la plage et des dunes d\\\'Essaouira.\', \'Une balade en quad d\\\'environ 1h30 le long de la plage d\\\'Essaouira et dans les dunes environnantes, encadree par un guide. Sensations garanties, aucune experience requise.\', 350, 1, 10, \'Quad, casque, guide\', \'Assurance dommages, carburant additionnel\', \'Base quad, route de Marrakech, Essaouira\', \'15:00\', \'16:30\', \'1h30\', \'Modéré\', 0, 1, 0, 1, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 8 DAY));');
        $this->addSql('SET @product_quad := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_quad, @dest_essaouira);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'coast.jpg\', \'Balade en quad sur la plage\');');
        $this->addSql('SET @asset_quad_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_quad, @asset_quad_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_quad, \'coast-2.jpg\', \'Balade en quad sur la plage\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'ocean.jpg\', \'Balade en quad sur la plage\');');
        $this->addSql('SET @asset_quad_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_quad, @asset_quad_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_quad, \'ocean-2.jpg\', \'Balade en quad sur la plage\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_atlantic, @cat_journee, @dest_marrakech, \'Excursion Essaouira depuis Marrakech\', \'excursion-essaouira-depuis-marrakech\', \'Journee a Essaouira, la cite des Alizes, au depart de Marrakech.\', \'Route vers la cote atlantique et decouverte d\\\'Essaouira : remparts, port aux mouettes, medina classee UNESCO et temps libre pour flaner dans les souks.\', 400, 1, 20, \'Transport climatise, guide francophone\', \'Dejeuner, activites nautiques\', \'Jemaa el-Fna, devant la pharmacie centrale\', \'07:30\', \'19:30\', \'1 jour\', \'Facile\', 1, 1, 0, 0, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 33 DAY));');
        $this->addSql('SET @product_essaouira_mrk := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_essaouira_mrk, @dest_marrakech);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'ocean.jpg\', \'Excursion Essaouira depuis Marrakech\');');
        $this->addSql('SET @asset_essaouira_mrk_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_essaouira_mrk, @asset_essaouira_mrk_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_essaouira_mrk, \'ocean-2.jpg\', \'Excursion Essaouira depuis Marrakech\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'souk.jpg\', \'Excursion Essaouira depuis Marrakech\');');
        $this->addSql('SET @asset_essaouira_mrk_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_essaouira_mrk, @asset_essaouira_mrk_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_essaouira_mrk, \'souk-2.jpg\', \'Excursion Essaouira depuis Marrakech\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_atlantic, @cat_nautique, @dest_essaouira, \'Sortie kitesurf initiation\', \'sortie-kitesurf-initiation-essaouira\', \'Initiation au kitesurf sur le spot de Moulay Bouzerktoune.\', \'Session d\\\'initiation au kitesurf encadree par un moniteur IKO, sur l\\\'un des meilleurs spots du Maroc. Materiel complet fourni, adapte aux debutants.\', 500, 1, 6, \'Materiel de kitesurf, moniteur IKO, assurance\', \'Transport, hebergement\', \'Spot de Moulay Bouzerktoune\', \'09:00\', \'12:00\', \'3 heures\', \'Modéré\', 0, 1, 0, 1, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 5 DAY));');
        $this->addSql('SET @product_kitesurf := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_kitesurf, @dest_essaouira);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'coast.jpg\', \'Sortie kitesurf initiation\');');
        $this->addSql('SET @asset_kitesurf_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_kitesurf, @asset_kitesurf_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_kitesurf, \'coast-2.jpg\', \'Sortie kitesurf initiation\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'ocean.jpg\', \'Sortie kitesurf initiation\');');
        $this->addSql('SET @asset_kitesurf_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_kitesurf, @asset_kitesurf_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_kitesurf, \'ocean-2.jpg\', \'Sortie kitesurf initiation\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_imperial, @cat_journee, @dest_fes, \'Visite guidée de la médina de Fès\', \'visite-guidee-medina-fes\', \'Decouverte de la plus grande medina pietonne du monde avec un guide agree.\', \'Visite guidee de Fes el-Bali : tanneries traditionnelles, medersa Bou Inania, souks des artisans et place Seffarine. Un guide officiel vous aide a vous reperer dans le dedale de ruelles classees UNESCO.\', 200, 1, 15, \'Guide officiel agree, entrees des monuments\', \'Dejeuner, achats\', \'Bab Boujloud, Fès\', \'09:30\', \'13:00\', \'3h30\', \'Facile\', 0, 1, 0, 0, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 45 DAY));');
        $this->addSql('SET @product_medina_fes := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_medina_fes, @dest_fes);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'medina.jpg\', \'Visite guidée de la médina de Fès\');');
        $this->addSql('SET @asset_medina_fes_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_medina_fes, @asset_medina_fes_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_medina_fes, \'medina-2.jpg\', \'Visite guidée de la médina de Fès\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'souk.jpg\', \'Visite guidée de la médina de Fès\');');
        $this->addSql('SET @asset_medina_fes_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_medina_fes, @asset_medina_fes_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_medina_fes, \'souk-2.jpg\', \'Visite guidée de la médina de Fès\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_imperial, @cat_circuits, @dest_fes, \'Circuit villes impériales 5 jours\', \'circuit-villes-imperiales-5-jours\', \'Circuit de 5 jours entre Fes, Meknes, Rabat et Casablanca.\', \'Un circuit complet a travers les villes imperiales du Maroc : Fes et sa medina, Meknes et ses portes monumentales, Rabat la capitale et Casablanca et sa mosquee Hassan II. Hebergement en hotels 3-4 etoiles inclus.\', 3200, 2, 12, \'Transport climatise, guide national, hebergement 4 nuits, petits-dejeuners\', \'Dejeuners et diners, entrees optionnelles\', \'Aeroport de Fès-Saïss\', \'09:00\', \'Jour 5, 18:00\', \'5 jours / 4 nuits\', \'Facile\', 1, 1, 1, 0, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 50 DAY));');
        $this->addSql('SET @product_circuit5j := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_circuit5j, @dest_fes);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'medina.jpg\', \'Circuit villes impériales 5 jours\');');
        $this->addSql('SET @asset_circuit5j_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_circuit5j, @asset_circuit5j_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_circuit5j, \'medina-2.jpg\', \'Circuit villes impériales 5 jours\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'kasbah.jpg\', \'Circuit villes impériales 5 jours\');');
        $this->addSql('SET @asset_circuit5j_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_circuit5j, @asset_circuit5j_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_circuit5j, \'kasbah-2.jpg\', \'Circuit villes impériales 5 jours\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_imperial, @cat_transfert, @dest_fes, \'Transfert aéroport Fès-Saïss\', \'transfert-aeroport-fes-saiss\', \'Transfert prive entre l\\\'aeroport de Fes et votre hebergement.\', \'Transfert prive et confortable entre l\\\'aeroport de Fes-Saiss et votre hotel ou riad, en vehicule climatise avec chauffeur. Suivi de votre vol inclus.\', 150, 1, 4, \'Vehicule prive, chauffeur, suivi de vol\', \'Bagages excedentaires\', \'Hall des arrivees, Aéroport Fès-Saïss\', \'Selon vol\', \'Selon vol\', \'30-45 min\', \'Facile\', 1, 0, 0, 1, \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 3 DAY));');
        $this->addSql('SET @product_transfert_fes := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_transfert_fes, @dest_fes);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'medina.jpg\', \'Transfert aéroport Fès-Saïss\');');
        $this->addSql('SET @asset_transfert_fes_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_transfert_fes, @asset_transfert_fes_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_transfert_fes, \'medina-2.jpg\', \'Transfert aéroport Fès-Saïss\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'garden.jpg\', \'Transfert aéroport Fès-Saïss\');');
        $this->addSql('SET @asset_transfert_fes_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_transfert_fes, @asset_transfert_fes_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_transfert_fes, \'garden-2.jpg\', \'Transfert aéroport Fès-Saïss\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_atlas, @cat_journee, @dest_marrakech, \'Excursion Agafay Desert Sunset Dinner\', \'excursion-agafay-desert-sunset-dinner\', \'Soiree diner-spectacle dans le desert d\\\'Agafay au coucher du soleil, a 30 minutes de Marrakech.\', \'Depart en fin d\\\'apres-midi vers le desert rocailleux d\\\'Agafay. Apero au coucher du soleil, diner sous tente berbere avec spectacle de musiciens et danseurs. Retour a Marrakech en soiree.\', 550, 2, 10, \'Transport, apero, diner, spectacle\', \'Boissons alcoolisees, activites optionnelles (quad, chameau)\', \'Jemaa el-Fna, devant la pharmacie centrale\', \'16:30\', \'22:30\', \'6 heures\', \'Facile\', 1, 1, 1, 0, \'PENDING_REVIEW\', DATE_SUB(NOW(), INTERVAL 2 DAY));');
        $this->addSql('SET @product_agafay := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_agafay, @dest_marrakech);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'sahara.jpg\', \'Excursion Agafay Desert Sunset Dinner\');');
        $this->addSql('SET @asset_agafay_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_agafay, @asset_agafay_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_agafay, \'sahara-2.jpg\', \'Excursion Agafay Desert Sunset Dinner\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'palm.jpg\', \'Excursion Agafay Desert Sunset Dinner\');');
        $this->addSql('SET @asset_agafay_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_agafay, @asset_agafay_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_agafay, \'palm-2.jpg\', \'Excursion Agafay Desert Sunset Dinner\', 1, 0);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_atlas, @cat_journee, @dest_marrakech, \'Excursion nocturne Ourika (test)\', \'excursion-nocturne-ourika-test\', \'Excursion en cours de finalisation, non retenue en l\\\'etat.\', \'Fiche en attente de mise a jour par l\\\'agence : description a completer avant nouvelle soumission.\', 280, 1, 10, \'Transport\', \'Non precise\', \'Marrakech\', \'18:00\', \'23:00\', \'5 heures\', \'Facile\', 1, 0, 0, 0, \'REJECTED\', DATE_SUB(NOW(), INTERVAL 6 DAY));');
        $this->addSql('SET @product_ourika_nuit := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_ourika_nuit, @dest_marrakech);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'mountains.jpg\', \'Excursion nocturne Ourika (test)\');');
        $this->addSql('SET @asset_ourika_nuit_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_ourika_nuit, @asset_ourika_nuit_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_ourika_nuit, \'mountains-2.jpg\', \'Excursion nocturne Ourika (test)\', 0, 1);');
        $this->addSql('INSERT INTO product (agency, category_id, destination_id, product_name, product_slug, product_short_description, product_long_description, product_price, min_persons, max_persons, inclusions, exclusions, meeting_point, departure_time, return_time, product_duration, difficulty, transport_included, guide_included, meals_included, is_private, status, date_create) VALUES (@agency_nomads, @cat_journee, @dest_ouarzazate, \'Visite des studios de cinéma Atlas\', \'visite-studios-cinema-atlas\', \'Visite des celebres studios de cinema d\\\'Ouarzazate, le \\"Hollywood du desert\\".\', \'Decouverte des plus grands studios de cinema d\\\'Afrique, ou ont ete tournes de nombreux films et series internationaux. Decors grandeur nature, costumes et accessoires exposes.\', 250, 1, 15, \'Guide, entree aux studios\', \'Transport, dejeuner\', \'Centre-ville, Ouarzazate\', \'10:00\', \'13:00\', \'3 heures\', \'Facile\', 0, 1, 0, 0, \'PENDING_REVIEW\', DATE_SUB(NOW(), INTERVAL 1 DAY));');
        $this->addSql('SET @product_studios_atlas := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_destination (product_id, destination_id) VALUES (@product_studios_atlas, @dest_ouarzazate);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (1, \'kasbah.jpg\', \'Visite des studios de cinéma Atlas\');');
        $this->addSql('SET @asset_studios_atlas_1 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_studios_atlas, @asset_studios_atlas_1);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_studios_atlas, \'kasbah-2.jpg\', \'Visite des studios de cinéma Atlas\', 0, 1);');
        $this->addSql('INSERT INTO asset (asset_is_main, asset_base_path, asset_title) VALUES (0, \'souk.jpg\', \'Visite des studios de cinéma Atlas\');');
        $this->addSql('SET @asset_studios_atlas_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO product_has_asset (product_id, asset_id) VALUES (@product_studios_atlas, @asset_studios_atlas_2);');
        $this->addSql('INSERT INTO excursion_image (product_id, path, alt_text, position, is_main) VALUES (@product_studios_atlas, \'souk-2.jpg\', \'Visite des studios de cinéma Atlas\', 1, 0);');
        $this->addSql('
-- ===== EXCURSION SCHEDULES =====');
        $this->addSql('INSERT INTO excursion_schedule (product_id, date, time, capacity, remaining_capacity, price, status) VALUES (@product_bivouac, DATE_ADD(CURDATE(), INTERVAL 5 DAY), \'17:00\', 12, 4, NULL, \'OPEN\');');
        $this->addSql('INSERT INTO excursion_schedule (product_id, date, time, capacity, remaining_capacity, price, status) VALUES (@product_bivouac, DATE_ADD(CURDATE(), INTERVAL 12 DAY), \'17:00\', 12, 0, NULL, \'FULL\');');
        $this->addSql('INSERT INTO excursion_schedule (product_id, date, time, capacity, remaining_capacity, price, status) VALUES (@product_bivouac, DATE_ADD(CURDATE(), INTERVAL 19 DAY), \'17:00\', 12, 12, NULL, \'OPEN\');');
        $this->addSql('INSERT INTO excursion_schedule (product_id, date, time, capacity, remaining_capacity, price, status) VALUES (@product_circuit3j, DATE_ADD(CURDATE(), INTERVAL 8 DAY), NULL, 8, 3, NULL, \'OPEN\');');
        $this->addSql('INSERT INTO excursion_schedule (product_id, date, time, capacity, remaining_capacity, price, status) VALUES (@product_circuit3j, DATE_ADD(CURDATE(), INTERVAL 22 DAY), NULL, 8, 8, NULL, \'OPEN\');');
        $this->addSql('INSERT INTO excursion_schedule (product_id, date, time, capacity, remaining_capacity, price, status) VALUES (@product_circuit5j, DATE_ADD(CURDATE(), INTERVAL 15 DAY), NULL, 12, 5, 3200, \'OPEN\');');
        $this->addSql('
-- ===== EXCURSION ITINERARIES =====');
        $this->addSql('INSERT INTO excursion_itinerary (product_id, position, time, title, description, duration, location) VALUES (@product_circuit3j, 0, \'07:00\', \'Marrakech → Aït Ben Haddou\', \'Traversee du col du Tichka, visite du ksar d\\\'Ait Ben Haddou (UNESCO) puis route vers la vallee du Dades.\', \'8 heures\', \'Aït Ben Haddou\');');
        $this->addSql('INSERT INTO excursion_itinerary (product_id, position, time, title, description, duration, location) VALUES (@product_circuit3j, 1, \'08:00\', \'Vallée du Dadès → Merzouga\', \'Route par les Gorges du Todra puis arrivee a Merzouga en fin d\\\'apres-midi pour le bivouac dans le desert.\', \'9 heures\', \'Merzouga\');');
        $this->addSql('INSERT INTO excursion_itinerary (product_id, position, time, title, description, duration, location) VALUES (@product_circuit3j, 2, \'08:00\', \'Merzouga → Marrakech\', \'Lever de soleil sur les dunes puis retour direct vers Marrakech.\', \'10 heures\', \'Marrakech\');');
        $this->addSql('INSERT INTO excursion_itinerary (product_id, position, time, title, description, duration, location) VALUES (@product_circuit5j, 0, \'09:00\', \'Arrivée & Fès\', \'Accueil a l\\\'aeroport de Fes-Saiss et visite de la medina l\\\'apres-midi.\', \'4 heures\', \'Fès\');');
        $this->addSql('INSERT INTO excursion_itinerary (product_id, position, time, title, description, duration, location) VALUES (@product_circuit5j, 1, \'09:00\', \'Fès → Meknès → Rabat\', \'Visite de Meknes et de ses portes monumentales, puis route vers Rabat.\', \'6 heures\', \'Rabat\');');
        $this->addSql('INSERT INTO excursion_itinerary (product_id, position, time, title, description, duration, location) VALUES (@product_circuit5j, 2, \'09:00\', \'Rabat\', \'Visite de la Tour Hassan, du Mausolee Mohammed V et de la Kasbah des Oudayas.\', \'4 heures\', \'Rabat\');');
        $this->addSql('INSERT INTO excursion_itinerary (product_id, position, time, title, description, duration, location) VALUES (@product_circuit5j, 3, \'09:00\', \'Rabat → Casablanca\', \'Route vers Casablanca et visite de la Mosquee Hassan II.\', \'3 heures\', \'Casablanca\');');
        $this->addSql('INSERT INTO excursion_itinerary (product_id, position, time, title, description, duration, location) VALUES (@product_circuit5j, 4, \'10:00\', \'Casablanca → Départ\', \'Temps libre puis transfert vers l\\\'aeroport ou votre prochaine destination.\', \'2 heures\', \'Casablanca\');');
        $this->addSql('
-- ===== MARKETPLACE BOOKINGS =====');
        $this->addSql('INSERT INTO marketplace_booking (user_id, product_id, agency_id, reference, date, adults, children, total_participants, unit_price, total_price, currency, customer_name, customer_phone, customer_email, status, date_create, date_update) VALUES (@user_client1, @product_ourika, @agency_atlas, \'EXC-DEMO-0001\', DATE_SUB(CURDATE(), INTERVAL 20 DAY), 2, 0, 2, 350, 700, \'MAD\', \'Sara Amrani\', \'+212600000020\', \'sara.amrani@example.com\', \'COMPLETED\', DATE_SUB(NOW(), INTERVAL 23 DAY), NOW());');
        $this->addSql('SET @booking_EXC_DEMO_0001 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO marketplace_booking (user_id, product_id, agency_id, reference, date, adults, children, total_participants, unit_price, total_price, currency, customer_name, customer_phone, customer_email, status, date_create, date_update) VALUES (@user_client1, @product_bivouac, @agency_sahara, \'EXC-DEMO-0002\', DATE_ADD(CURDATE(), INTERVAL 5 DAY), 2, 1, 3, 450, 1350, \'MAD\', \'Sara Amrani\', \'+212600000020\', \'sara.amrani@example.com\', \'CONFIRMED\', NOW(), NOW());');
        $this->addSql('SET @booking_EXC_DEMO_0002 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO marketplace_booking (user_id, product_id, agency_id, reference, date, adults, children, total_participants, unit_price, total_price, currency, customer_name, customer_phone, customer_email, status, date_create, date_update) VALUES (@user_client2, @product_chameau, @agency_sahara, \'EXC-DEMO-0003\', DATE_ADD(CURDATE(), INTERVAL 9 DAY), 4, 0, 4, 200, 800, \'MAD\', \'Youssef El Idrissi\', \'+33600000021\', \'youssef.elidrissi@example.com\', \'PENDING\', NOW(), NOW());');
        $this->addSql('SET @booking_EXC_DEMO_0003 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO marketplace_booking (user_id, product_id, agency_id, reference, date, adults, children, total_participants, unit_price, total_price, currency, customer_name, customer_phone, customer_email, status, date_create, date_update) VALUES (@user_client2, @product_surf, @agency_atlantic, \'EXC-DEMO-0004\', DATE_SUB(CURDATE(), INTERVAL 8 DAY), 1, 0, 1, 300, 300, \'MAD\', \'Youssef El Idrissi\', \'+33600000021\', \'youssef.elidrissi@example.com\', \'COMPLETED\', DATE_SUB(NOW(), INTERVAL 11 DAY), NOW());');
        $this->addSql('SET @booking_EXC_DEMO_0004 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO marketplace_booking (user_id, product_id, agency_id, reference, date, adults, children, total_participants, unit_price, total_price, currency, customer_name, customer_phone, customer_email, status, date_create, date_update) VALUES (@user_client3, @product_medina_fes, @agency_imperial, \'EXC-DEMO-0005\', DATE_SUB(CURDATE(), INTERVAL 14 DAY), 2, 0, 2, 200, 400, \'MAD\', \'Nadia Bensouda\', \'+212600000022\', \'nadia.bensouda@example.com\', \'COMPLETED\', DATE_SUB(NOW(), INTERVAL 17 DAY), NOW());');
        $this->addSql('SET @booking_EXC_DEMO_0005 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO marketplace_booking (user_id, product_id, agency_id, reference, date, adults, children, total_participants, unit_price, total_price, currency, customer_name, customer_phone, customer_email, status, date_create, date_update) VALUES (@user_client3, @product_circuit3j, @agency_atlas, \'EXC-DEMO-0006\', DATE_ADD(CURDATE(), INTERVAL 8 DAY), 2, 0, 2, 1800, 3600, \'MAD\', \'Nadia Bensouda\', \'+212600000022\', \'nadia.bensouda@example.com\', \'CONFIRMED\', NOW(), NOW());');
        $this->addSql('SET @booking_EXC_DEMO_0006 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO marketplace_booking (user_id, product_id, agency_id, reference, date, adults, children, total_participants, unit_price, total_price, currency, customer_name, customer_phone, customer_email, status, date_create, date_update) VALUES (NULL, @product_quad, @agency_atlantic, \'EXC-DEMO-0007\', DATE_ADD(CURDATE(), INTERVAL 6 DAY), 2, 0, 2, 350, 700, \'MAD\', \'Marc Dubois\', \'+33612345678\', \'marc.dubois@example.com\', \'PENDING\', NOW(), NOW());');
        $this->addSql('SET @booking_EXC_DEMO_0007 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO marketplace_booking (user_id, product_id, agency_id, reference, date, adults, children, total_participants, unit_price, total_price, currency, customer_name, customer_phone, customer_email, status, date_create, date_update) VALUES (@user_client1, @product_x4erg, @agency_sahara, \'EXC-DEMO-0008\', DATE_SUB(CURDATE(), INTERVAL 5 DAY), 3, 0, 3, 550, 1650, \'MAD\', \'Sara Amrani\', \'+212600000020\', \'sara.amrani@example.com\', \'REJECTED\', DATE_SUB(NOW(), INTERVAL 8 DAY), NOW());');
        $this->addSql('SET @booking_EXC_DEMO_0008 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO marketplace_booking (user_id, product_id, agency_id, reference, date, adults, children, total_participants, unit_price, total_price, currency, customer_name, customer_phone, customer_email, status, date_create, date_update) VALUES (@user_client2, @product_kitesurf, @agency_atlantic, \'EXC-DEMO-0009\', DATE_ADD(CURDATE(), INTERVAL 14 DAY), 1, 0, 1, 500, 500, \'MAD\', \'Youssef El Idrissi\', \'+33600000021\', \'youssef.elidrissi@example.com\', \'PENDING\', NOW(), NOW());');
        $this->addSql('SET @booking_EXC_DEMO_0009 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO marketplace_booking (user_id, product_id, agency_id, reference, date, adults, children, total_participants, unit_price, total_price, currency, customer_name, customer_phone, customer_email, status, date_create, date_update) VALUES (@user_client3, @product_akchour, @agency_bluepearl, \'EXC-DEMO-0010\', DATE_SUB(CURDATE(), INTERVAL 10 DAY), 2, 0, 2, 250, 500, \'MAD\', \'Nadia Bensouda\', \'+212600000022\', \'nadia.bensouda@example.com\', \'COMPLETED\', DATE_SUB(NOW(), INTERVAL 13 DAY), NOW());');
        $this->addSql('SET @booking_EXC_DEMO_0010 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO marketplace_booking (user_id, product_id, agency_id, reference, date, adults, children, total_participants, unit_price, total_price, currency, customer_name, customer_phone, customer_email, status, date_create, date_update) VALUES (NULL, @product_transfert_fes, @agency_imperial, \'EXC-DEMO-0011\', DATE_ADD(CURDATE(), INTERVAL 3 DAY), 2, 0, 2, 150, 300, \'MAD\', \'Elena Rossi\', \'+39331234567\', \'elena.rossi@example.com\', \'CONFIRMED\', NOW(), NOW());');
        $this->addSql('SET @booking_EXC_DEMO_0011 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO marketplace_booking (user_id, product_id, agency_id, reference, date, adults, children, total_participants, unit_price, total_price, currency, customer_name, customer_phone, customer_email, status, date_create, date_update) VALUES (@user_client1, @product_circuit5j, @agency_imperial, \'EXC-DEMO-0012\', DATE_SUB(CURDATE(), INTERVAL 30 DAY), 2, 0, 2, 3200, 6400, \'MAD\', \'Sara Amrani\', \'+212600000020\', \'sara.amrani@example.com\', \'COMPLETED\', DATE_SUB(NOW(), INTERVAL 33 DAY), NOW());');
        $this->addSql('SET @booking_EXC_DEMO_0012 := LAST_INSERT_ID();');
        $this->addSql('
-- ===== REVIEWS =====');
        $this->addSql('INSERT INTO review (booking_id, user_id, product_id, agency_id, rating, comment, status, date_create, agency_reply, agency_reply_date) VALUES (@booking_EXC_DEMO_0001, @user_client1, @product_ourika, @agency_atlas, 5, \'Superbe journee ! Le guide etait tres sympathique et connaissait parfaitement la region. Les cascades sont magnifiques, je recommande vivement.\', \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 2 DAY), \'Merci beaucoup Sara pour votre retour, ravis que la journee vous ait plu ! Au plaisir de vous accueillir a nouveau.\', NOW());');
        $this->addSql('INSERT INTO review (booking_id, user_id, product_id, agency_id, rating, comment, status, date_create) VALUES (@booking_EXC_DEMO_0004, @user_client2, @product_surf, @agency_atlantic, 4, \'Tres bon cours, le moniteur est patient et pedagogue. J\\\'ai reussi a me lever sur la planche des la premiere session. Petit bemol sur le materiel un peu use.\', \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 2 DAY));');
        $this->addSql('INSERT INTO review (booking_id, user_id, product_id, agency_id, rating, comment, status, date_create, agency_reply, agency_reply_date) VALUES (@booking_EXC_DEMO_0005, @user_client3, @product_medina_fes, @agency_imperial, 5, \'Guide passionnant, on sent qu\\\'il connait chaque recoin de la medina. Une experience culturelle incroyable, merci !\', \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 2 DAY), \'Merci Nadia, c\\\'est un plaisir de faire decouvrir Fes a des voyageurs curieux comme vous !\', NOW());');
        $this->addSql('INSERT INTO review (booking_id, user_id, product_id, agency_id, rating, comment, status, date_create) VALUES (@booking_EXC_DEMO_0010, @user_client3, @product_akchour, @agency_bluepearl, 4, \'Belle randonnee, paysages superbes. Un peu plus de pauses auraient ete appreciees mais globalement tres satisfaite.\', \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 2 DAY));');
        $this->addSql('INSERT INTO review (booking_id, user_id, product_id, agency_id, rating, comment, status, date_create, agency_reply, agency_reply_date) VALUES (@booking_EXC_DEMO_0012, @user_client1, @product_circuit5j, @agency_imperial, 5, \'Circuit tres bien organise du debut a la fin, hotels de qualite et chauffeur tres professionnel. Une belle decouverte des villes imperiales.\', \'PUBLISHED\', DATE_SUB(NOW(), INTERVAL 2 DAY), \'Merci infiniment pour ce retour Sara, toute l\\\'equipe est ravie que le circuit vous ait plu !\', NOW());');
        $this->addSql('
-- ===== FAVORITES =====');
        $this->addSql('INSERT INTO favorite (user_id, product_id, date_create) VALUES (@user_client1, @product_bivouac, NOW());');
        $this->addSql('INSERT INTO favorite (user_id, product_id, date_create) VALUES (@user_client1, @product_circuit5j, NOW());');
        $this->addSql('INSERT INTO favorite (user_id, product_id, date_create) VALUES (@user_client2, @product_kitesurf, NOW());');
        $this->addSql('INSERT INTO favorite (user_id, product_id, date_create) VALUES (@user_client2, @product_medina_chef, NOW());');
        $this->addSql('INSERT INTO favorite (user_id, product_id, date_create) VALUES (@user_client3, @product_ourika, NOW());');
        $this->addSql('
-- ===== HOMEPAGE CMS CONTENT =====');
        $this->addSql('INSERT INTO page (page_name, page_title, page_sub_title, page_short_description) VALUES (\'home\', \'ExcursionMaroc — Excursions et circuits au Maroc\', \'Reservez vos excursions aupres d\\\'agences locales verifiees\', \'Marketplace d\\\'excursions et de circuits au Maroc : reservez en ligne aupres d\\\'agences locales verifiees, sans commission.\');');
        $this->addSql('SET @page_home := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO section (page_id, section_title, section_sub_title, section_description, section_order, section_type) VALUES (@page_home, \'Bienvenue sur ExcursionMaroc\', \'La marketplace des excursions marocaines\', \'<p>ExcursionMaroc.com met en relation les voyageurs avec des agences locales certifiees partout au Maroc : Marrakech, Fes, Chefchaouen, Merzouga, Essaouira et bien d\\\'autres. Reservez en toute confiance, sans commission.</p>\', 1, NULL);');
        $this->addSql('INSERT INTO section (page_id, section_title, section_sub_title, section_order, section_type) VALUES (@page_home, \'Excursions populaires\', \'Les incontournables selectionnes pour vous\', 2, 4);');
        $this->addSql('SET @section_2 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO section_has_product (section_id, product_id) VALUES (@section_2, @product_ourika);');
        $this->addSql('INSERT INTO section_has_product (section_id, product_id) VALUES (@section_2, @product_medina_chef);');
        $this->addSql('INSERT INTO section_has_product (section_id, product_id) VALUES (@section_2, @product_surf);');
        $this->addSql('INSERT INTO section_has_product (section_id, product_id) VALUES (@section_2, @product_medina_fes);');
        $this->addSql('INSERT INTO section_has_product (section_id, product_id) VALUES (@section_2, @product_ouzoud);');
        $this->addSql('INSERT INTO section_has_product (section_id, product_id) VALUES (@section_2, @product_essaouira_mrk);');
        $this->addSql('INSERT INTO section (page_id, section_title, section_sub_title, section_order, section_type) VALUES (@page_home, \'Désert & circuits\', \'Vivez l\\\'aventure dans le Sahara et sur les routes du Maroc\', 3, 4);');
        $this->addSql('SET @section_3 := LAST_INSERT_ID();');
        $this->addSql('INSERT INTO section_has_product (section_id, product_id) VALUES (@section_3, @product_bivouac);');
        $this->addSql('INSERT INTO section_has_product (section_id, product_id) VALUES (@section_3, @product_chameau);');
        $this->addSql('INSERT INTO section_has_product (section_id, product_id) VALUES (@section_3, @product_x4erg);');
        $this->addSql('INSERT INTO section_has_product (section_id, product_id) VALUES (@section_3, @product_circuit3j);');
        $this->addSql('INSERT INTO section_has_product (section_id, product_id) VALUES (@section_3, @product_circuit5j);');
        $this->addSql('INSERT INTO section_has_product (section_id, product_id) VALUES (@section_3, @product_roses);');

    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM review WHERE booking_id IN (SELECT id FROM (SELECT id FROM marketplace_booking WHERE reference LIKE 'EXC-DEMO-%') t)");
        $this->addSql("DELETE FROM favorite WHERE user_id IN (SELECT id FROM (SELECT id FROM user WHERE email LIKE '%@example.com') t)");
        $this->addSql("DELETE FROM marketplace_booking WHERE reference LIKE 'EXC-DEMO-%'");
        $this->addSql("DELETE FROM excursion_schedule WHERE product_id IN (SELECT id FROM (SELECT product_id AS id FROM product WHERE product_slug IN (
            'excursion-vallee-ourika-cascades','trek-vallee-des-roses-atlas','excursion-cascades-ouzoud','circuit-3-jours-marrakech-desert-merzouga',
            'nuit-desert-merzouga-bivouac','balade-chameau-coucher-soleil','circuit-4x4-erg-chebbi',
            'visite-guidee-medina-bleue-chefchaouen','randonnee-cascade-akchour','excursion-chefchaouen-depuis-tanger',
            'cours-surf-essaouira','balade-quad-plage-essaouira','excursion-essaouira-depuis-marrakech','sortie-kitesurf-initiation-essaouira',
            'visite-guidee-medina-fes','circuit-villes-imperiales-5-jours','transfert-aeroport-fes-saiss',
            'excursion-agafay-desert-sunset-dinner','excursion-nocturne-ourika-test','visite-studios-cinema-atlas'
        )) t)");
        $this->addSql("DELETE FROM excursion_itinerary WHERE product_id IN (SELECT id FROM (SELECT product_id AS id FROM product WHERE product_slug IN (
            'circuit-3-jours-marrakech-desert-merzouga','circuit-villes-imperiales-5-jours'
        )) t)");
        $this->addSql("DELETE FROM excursion_image WHERE product_id IN (SELECT id FROM (SELECT product_id AS id FROM product WHERE product_slug IN (
            'excursion-vallee-ourika-cascades','trek-vallee-des-roses-atlas','excursion-cascades-ouzoud','circuit-3-jours-marrakech-desert-merzouga',
            'nuit-desert-merzouga-bivouac','balade-chameau-coucher-soleil','circuit-4x4-erg-chebbi',
            'visite-guidee-medina-bleue-chefchaouen','randonnee-cascade-akchour','excursion-chefchaouen-depuis-tanger',
            'cours-surf-essaouira','balade-quad-plage-essaouira','excursion-essaouira-depuis-marrakech','sortie-kitesurf-initiation-essaouira',
            'visite-guidee-medina-fes','circuit-villes-imperiales-5-jours','transfert-aeroport-fes-saiss',
            'excursion-agafay-desert-sunset-dinner','excursion-nocturne-ourika-test','visite-studios-cinema-atlas'
        )) t)");
        $this->addSql("DELETE pha FROM product_has_asset pha INNER JOIN product p ON p.product_id = pha.product_id WHERE p.product_slug IN (
            'excursion-vallee-ourika-cascades','trek-vallee-des-roses-atlas','excursion-cascades-ouzoud','circuit-3-jours-marrakech-desert-merzouga',
            'nuit-desert-merzouga-bivouac','balade-chameau-coucher-soleil','circuit-4x4-erg-chebbi',
            'visite-guidee-medina-bleue-chefchaouen','randonnee-cascade-akchour','excursion-chefchaouen-depuis-tanger',
            'cours-surf-essaouira','balade-quad-plage-essaouira','excursion-essaouira-depuis-marrakech','sortie-kitesurf-initiation-essaouira',
            'visite-guidee-medina-fes','circuit-villes-imperiales-5-jours','transfert-aeroport-fes-saiss',
            'excursion-agafay-desert-sunset-dinner','excursion-nocturne-ourika-test','visite-studios-cinema-atlas'
        )");
        $this->addSql("DELETE FROM asset WHERE asset_title IN (SELECT t.n FROM (SELECT product_name AS n FROM product WHERE product_slug IN (
            'excursion-vallee-ourika-cascades','trek-vallee-des-roses-atlas','excursion-cascades-ouzoud','circuit-3-jours-marrakech-desert-merzouga',
            'nuit-desert-merzouga-bivouac','balade-chameau-coucher-soleil','circuit-4x4-erg-chebbi',
            'visite-guidee-medina-bleue-chefchaouen','randonnee-cascade-akchour','excursion-chefchaouen-depuis-tanger',
            'cours-surf-essaouira','balade-quad-plage-essaouira','excursion-essaouira-depuis-marrakech','sortie-kitesurf-initiation-essaouira',
            'visite-guidee-medina-fes','circuit-villes-imperiales-5-jours','transfert-aeroport-fes-saiss',
            'excursion-agafay-desert-sunset-dinner','excursion-nocturne-ourika-test','visite-studios-cinema-atlas'
        )) t)");
        $this->addSql("DELETE FROM product_has_destination WHERE product_id IN (SELECT id FROM (SELECT product_id AS id FROM product WHERE product_slug IN (
            'excursion-vallee-ourika-cascades','trek-vallee-des-roses-atlas','excursion-cascades-ouzoud','circuit-3-jours-marrakech-desert-merzouga',
            'nuit-desert-merzouga-bivouac','balade-chameau-coucher-soleil','circuit-4x4-erg-chebbi',
            'visite-guidee-medina-bleue-chefchaouen','randonnee-cascade-akchour','excursion-chefchaouen-depuis-tanger',
            'cours-surf-essaouira','balade-quad-plage-essaouira','excursion-essaouira-depuis-marrakech','sortie-kitesurf-initiation-essaouira',
            'visite-guidee-medina-fes','circuit-villes-imperiales-5-jours','transfert-aeroport-fes-saiss',
            'excursion-agafay-desert-sunset-dinner','excursion-nocturne-ourika-test','visite-studios-cinema-atlas'
        )) t)");
        $this->addSql("DELETE FROM product WHERE product_slug IN (
            'excursion-vallee-ourika-cascades','trek-vallee-des-roses-atlas','excursion-cascades-ouzoud','circuit-3-jours-marrakech-desert-merzouga',
            'nuit-desert-merzouga-bivouac','balade-chameau-coucher-soleil','circuit-4x4-erg-chebbi',
            'visite-guidee-medina-bleue-chefchaouen','randonnee-cascade-akchour','excursion-chefchaouen-depuis-tanger',
            'cours-surf-essaouira','balade-quad-plage-essaouira','excursion-essaouira-depuis-marrakech','sortie-kitesurf-initiation-essaouira',
            'visite-guidee-medina-fes','circuit-villes-imperiales-5-jours','transfert-aeroport-fes-saiss',
            'excursion-agafay-desert-sunset-dinner','excursion-nocturne-ourika-test','visite-studios-cinema-atlas'
        )");
        $this->addSql("DELETE FROM user_agency WHERE agency_id IN (SELECT id FROM (SELECT id FROM agency WHERE slug IN (
            'atlas-adventures','sahara-desert-tours','blue-pearl-travel','atlantic-coast-excursions','imperial-cities-voyages','desert-nomads-expeditions'
        )) t)");
        $this->addSql("DELETE FROM agency WHERE slug IN (
            'atlas-adventures','sahara-desert-tours','blue-pearl-travel','atlantic-coast-excursions','imperial-cities-voyages','desert-nomads-expeditions'
        )");
        $this->addSql("DELETE FROM destination WHERE destination_slug IN (
            'marrakech','fes','chefchaouen','essaouira','agadir','ouarzazate','merzouga','casablanca','rabat','tanger'
        )");
        $this->addSql("DELETE FROM category WHERE category_slug IN (
            'excursions-journee','circuits-multi-jours','desert-sahara','randonnee-trek','activites-nautiques','transferts-aeroport'
        )");
        $this->addSql("DELETE FROM user WHERE email IN (
            'admin@excursionmaroc.com','contact@atlas-adventures.ma','contact@sahara-desert-tours.ma','contact@bluepearltravel.ma',
            'contact@atlanticcoast.ma','contact@imperialcities.ma','contact@desertnomads.ma',
            'sara.amrani@example.com','youssef.elidrissi@example.com','nadia.bensouda@example.com'
        )");
        $this->addSql("DELETE FROM settings WHERE `key` IN (
            'application_name','application_about','application_description','application_email','application_phone','application_address'
        )");
        $this->addSql("DELETE shp FROM section_has_product shp INNER JOIN section s ON s.section_id = shp.section_id INNER JOIN page p ON p.page_id = s.page_id WHERE p.page_name = 'home'");
        $this->addSql("DELETE s FROM section s INNER JOIN page p ON p.page_id = s.page_id WHERE p.page_name = 'home'");
        $this->addSql("DELETE FROM page WHERE page_name = 'home'");
    }
}
