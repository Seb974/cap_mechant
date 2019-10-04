<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191004124207 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_customer DROP FOREIGN KEY FK_7E82D5E6BD94FB16');
        $this->addSql('ALTER TABLE sylius_order DROP FOREIGN KEY FK_6196A1F94D4CFF2B');
        $this->addSql('ALTER TABLE sylius_order DROP FOREIGN KEY FK_6196A1F979D0C0E4');
        $this->addSql('ALTER TABLE sylius_order DROP FOREIGN KEY FK_6196A1F972F5A1AA');
        $this->addSql('ALTER TABLE sylius_channel DROP FOREIGN KEY FK_16C8119E3101778E');
        $this->addSql('ALTER TABLE sylius_address DROP FOREIGN KEY FK_B97FF0589395C3F3');
        $this->addSql('ALTER TABLE sylius_order DROP FOREIGN KEY FK_6196A1F99395C3F3');
        $this->addSql('ALTER TABLE sylius_shop_user DROP FOREIGN KEY FK_7C2B74809395C3F3');
        $this->addSql('ALTER TABLE sylius_customer DROP FOREIGN KEY FK_7E82D5E6D2919A68');
        $this->addSql('ALTER TABLE sylius_payment_method DROP FOREIGN KEY FK_A75B0B0DF23D6140');
        $this->addSql('ALTER TABLE sylius_channel DROP FOREIGN KEY FK_16C8119E743BF776');
        $this->addSql('ALTER TABLE sylius_order_item DROP FOREIGN KEY FK_77B587ED8D9F6D38');
        $this->addSql('ALTER TABLE sylius_product_association DROP FOREIGN KEY FK_48E9CDAB4584665A');
        $this->addSql('ALTER TABLE sylius_product_image DROP FOREIGN KEY FK_88C64B2D7E3C61F9');
        $this->addSql('ALTER TABLE sylius_product_variant DROP FOREIGN KEY FK_A29B5234584665A');
        $this->addSql('ALTER TABLE sylius_product_association DROP FOREIGN KEY FK_48E9CDABB1E1C39');
        $this->addSql('ALTER TABLE sylius_product_option_value DROP FOREIGN KEY FK_F7FF7D4BA7C41D6F');
        $this->addSql('ALTER TABLE sylius_order_item DROP FOREIGN KEY FK_77B587ED3B69A9AF');
        $this->addSql('ALTER TABLE sylius_promotion_coupon DROP FOREIGN KEY FK_B04EBA85139DF194');
        $this->addSql('ALTER TABLE sylius_order DROP FOREIGN KEY FK_6196A1F917B24436');
        $this->addSql('ALTER TABLE sylius_product_variant DROP FOREIGN KEY FK_A29B5239E2D1A41');
        $this->addSql('ALTER TABLE sylius_shipping_method DROP FOREIGN KEY FK_5FB0EE1112469DE2');
        $this->addSql('ALTER TABLE sylius_channel DROP FOREIGN KEY FK_16C8119EB5282EDF');
        $this->addSql('ALTER TABLE sylius_product_variant DROP FOREIGN KEY FK_A29B5239DF894ED');
        $this->addSql('ALTER TABLE sylius_shipping_method DROP FOREIGN KEY FK_5FB0EE119DF894ED');
        $this->addSql('ALTER TABLE sylius_product DROP FOREIGN KEY FK_677B9B74731E505');
        $this->addSql('ALTER TABLE sylius_taxon DROP FOREIGN KEY FK_CFD811CA727ACA70');
        $this->addSql('ALTER TABLE sylius_taxon DROP FOREIGN KEY FK_CFD811CAA977936C');
        $this->addSql('CREATE TABLE metadata (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, city_id INT NOT NULL, facturation_address VARCHAR(255) DEFAULT NULL, delivery_address VARCHAR(255) DEFAULT NULL, phone_number INT DEFAULT NULL, UNIQUE INDEX UNIQ_4F143414A76ED395 (user_id), INDEX IDX_4F1434148BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE metadata ADD CONSTRAINT FK_4F143414A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE metadata ADD CONSTRAINT FK_4F1434148BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('DROP TABLE sylius_address');
        $this->addSql('DROP TABLE sylius_admin_api_client');
        $this->addSql('DROP TABLE sylius_admin_user');
        $this->addSql('DROP TABLE sylius_channel');
        $this->addSql('DROP TABLE sylius_country');
        $this->addSql('DROP TABLE sylius_currency');
        $this->addSql('DROP TABLE sylius_customer');
        $this->addSql('DROP TABLE sylius_customer_group');
        $this->addSql('DROP TABLE sylius_gateway_config');
        $this->addSql('DROP TABLE sylius_locale');
        $this->addSql('DROP TABLE sylius_order');
        $this->addSql('DROP TABLE sylius_order_item');
        $this->addSql('DROP TABLE sylius_payment_method');
        $this->addSql('DROP TABLE sylius_product');
        $this->addSql('DROP TABLE sylius_product_association');
        $this->addSql('DROP TABLE sylius_product_association_type');
        $this->addSql('DROP TABLE sylius_product_attribute');
        $this->addSql('DROP TABLE sylius_product_image');
        $this->addSql('DROP TABLE sylius_product_option');
        $this->addSql('DROP TABLE sylius_product_option_value');
        $this->addSql('DROP TABLE sylius_product_variant');
        $this->addSql('DROP TABLE sylius_promotion');
        $this->addSql('DROP TABLE sylius_promotion_coupon');
        $this->addSql('DROP TABLE sylius_shipping_category');
        $this->addSql('DROP TABLE sylius_shipping_method');
        $this->addSql('DROP TABLE sylius_shop_billing_data');
        $this->addSql('DROP TABLE sylius_shop_user');
        $this->addSql('DROP TABLE sylius_tax_category');
        $this->addSql('DROP TABLE sylius_taxon');
        $this->addSql('ALTER TABLE city ADD is_deliverable TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE nutritionals CHANGE k_cal k_cal DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE picture_id picture_id INT DEFAULT NULL, CHANGE nutritionals_id nutritionals_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE tva_id tva_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE avatar_id avatar_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE username username VARCHAR(60) DEFAULT NULL, CHANGE is_banned is_banned TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sylius_address (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, last_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, phone_number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, street VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, company VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, city VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, postcode VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', country_code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, province_code VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, province_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, INDEX IDX_B97FF0589395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_admin_api_client (id INT AUTO_INCREMENT NOT NULL, random_id VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, redirect_uris LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', secret VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, allowed_grant_types LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_admin_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, username_canonical VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, last_login DATETIME DEFAULT \'NULL\', password_reset_token VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, password_requested_at DATETIME DEFAULT \'NULL\', email_verification_token VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, verified_at DATETIME DEFAULT \'NULL\', locked TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT \'NULL\', credentials_expire_at DATETIME DEFAULT \'NULL\', roles LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, email_canonical VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', first_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, last_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, locale_code VARCHAR(12) NOT NULL COLLATE utf8_unicode_ci, encoder_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_channel (id INT AUTO_INCREMENT NOT NULL, default_locale_id INT NOT NULL, base_currency_id INT NOT NULL, default_tax_zone_id INT DEFAULT NULL, shop_billing_data_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, color VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, enabled TINYINT(1) NOT NULL, hostname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', theme_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, tax_calculation_strategy VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, contact_email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, skipping_shipping_step_allowed TINYINT(1) NOT NULL, skipping_payment_step_allowed TINYINT(1) NOT NULL, account_verification_required TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_16C8119E77153098 (code), INDEX IDX_16C8119E3101778E (base_currency_id), INDEX IDX_16C8119E743BF776 (default_locale_id), INDEX IDX_16C8119EE551C011 (hostname), UNIQUE INDEX UNIQ_16C8119EB5282EDF (shop_billing_data_id), INDEX IDX_16C8119EA978C17 (default_tax_zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_country (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(2) NOT NULL COLLATE utf8_unicode_ci, enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_E74256BF77153098 (code), INDEX IDX_E74256BF77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_currency (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(3) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', UNIQUE INDEX UNIQ_96EDD3D077153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_customer (id INT AUTO_INCREMENT NOT NULL, customer_group_id INT DEFAULT NULL, default_address_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, email_canonical VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, first_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, last_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, birthday DATETIME DEFAULT \'NULL\', gender VARCHAR(1) DEFAULT \'\'u\'\' NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', phone_number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, subscribed_to_newsletter TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_7E82D5E6E7927C74 (email), INDEX IDX_7E82D5E6D2919A68 (customer_group_id), UNIQUE INDEX UNIQ_7E82D5E6BD94FB16 (default_address_id), UNIQUE INDEX UNIQ_7E82D5E6A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_customer_group (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_7FCF9B0577153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_gateway_config (id INT AUTO_INCREMENT NOT NULL, gateway_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, factory_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, config JSON NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_locale (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(12) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', UNIQUE INDEX UNIQ_7BA1286477153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_order (id INT AUTO_INCREMENT NOT NULL, shipping_address_id INT DEFAULT NULL, billing_address_id INT DEFAULT NULL, channel_id INT DEFAULT NULL, promotion_coupon_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, notes LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, state VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, checkout_completed_at DATETIME DEFAULT \'NULL\', items_total INT NOT NULL, adjustments_total INT NOT NULL, total INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', currency_code VARCHAR(3) NOT NULL COLLATE utf8_unicode_ci, locale_code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, checkout_state VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, payment_state VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, shipping_state VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, token_value VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, customer_ip VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_6196A1F996901F54 (number), INDEX IDX_6196A1F972F5A1AA (channel_id), INDEX IDX_6196A1F9A393D2FB43625D9F (state, updated_at), UNIQUE INDEX UNIQ_6196A1F979D0C0E4 (billing_address_id), INDEX IDX_6196A1F99395C3F3 (customer_id), UNIQUE INDEX UNIQ_6196A1F94D4CFF2B (shipping_address_id), INDEX IDX_6196A1F917B24436 (promotion_coupon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_order_item (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, variant_id INT NOT NULL, quantity INT NOT NULL, unit_price INT NOT NULL, units_total INT NOT NULL, adjustments_total INT NOT NULL, total INT NOT NULL, is_immutable TINYINT(1) NOT NULL, product_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, variant_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, INDEX IDX_77B587ED8D9F6D38 (order_id), INDEX IDX_77B587ED3B69A9AF (variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_payment_method (id INT AUTO_INCREMENT NOT NULL, gateway_config_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, environment VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, is_enabled TINYINT(1) NOT NULL, position INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', UNIQUE INDEX UNIQ_A75B0B0D77153098 (code), INDEX IDX_A75B0B0DF23D6140 (gateway_config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_product (id INT AUTO_INCREMENT NOT NULL, main_taxon_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', enabled TINYINT(1) NOT NULL, variant_selection_method VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, average_rating DOUBLE PRECISION DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_677B9B7477153098 (code), INDEX IDX_677B9B74731E505 (main_taxon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_product_association (id INT AUTO_INCREMENT NOT NULL, association_type_id INT NOT NULL, product_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', UNIQUE INDEX product_association_idx (product_id, association_type_id), INDEX IDX_48E9CDAB4584665A (product_id), INDEX IDX_48E9CDABB1E1C39 (association_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_product_association_type (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', UNIQUE INDEX UNIQ_CCB8914C77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_product_attribute (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, storage_type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, configuration LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', position INT NOT NULL, UNIQUE INDEX UNIQ_BFAF484A77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_product_image (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, type VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, path VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_88C64B2D7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_product_option (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, position INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', UNIQUE INDEX UNIQ_E4C0EBEF77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_product_option_value (id INT AUTO_INCREMENT NOT NULL, option_id INT NOT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_F7FF7D4B77153098 (code), INDEX IDX_F7FF7D4BA7C41D6F (option_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_product_variant (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, tax_category_id INT DEFAULT NULL, shipping_category_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', position INT NOT NULL, version INT DEFAULT 1 NOT NULL, on_hold INT NOT NULL, on_hand INT NOT NULL, tracked TINYINT(1) NOT NULL, width DOUBLE PRECISION DEFAULT \'NULL\', height DOUBLE PRECISION DEFAULT \'NULL\', depth DOUBLE PRECISION DEFAULT \'NULL\', weight DOUBLE PRECISION DEFAULT \'NULL\', shipping_required TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_A29B52377153098 (code), INDEX IDX_A29B5239E2D1A41 (shipping_category_id), INDEX IDX_A29B5239DF894ED (tax_category_id), INDEX IDX_A29B5234584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_promotion (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, priority INT NOT NULL, exclusive TINYINT(1) NOT NULL, usage_limit INT DEFAULT NULL, used INT NOT NULL, coupon_based TINYINT(1) NOT NULL, starts_at DATETIME DEFAULT \'NULL\', ends_at DATETIME DEFAULT \'NULL\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', UNIQUE INDEX UNIQ_F157396377153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_promotion_coupon (id INT AUTO_INCREMENT NOT NULL, promotion_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, usage_limit INT DEFAULT NULL, used INT NOT NULL, expires_at DATETIME DEFAULT \'NULL\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', per_customer_usage_limit INT DEFAULT NULL, reusable_from_cancelled_orders TINYINT(1) DEFAULT \'1\' NOT NULL, UNIQUE INDEX UNIQ_B04EBA8577153098 (code), INDEX IDX_B04EBA85139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_shipping_category (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', UNIQUE INDEX UNIQ_B1D6465277153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_shipping_method (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, zone_id INT NOT NULL, tax_category_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, configuration LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', category_requirement INT NOT NULL, calculator VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, is_enabled TINYINT(1) NOT NULL, position INT NOT NULL, archived_at DATETIME DEFAULT \'NULL\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', UNIQUE INDEX UNIQ_5FB0EE1177153098 (code), INDEX IDX_5FB0EE119DF894ED (tax_category_id), INDEX IDX_5FB0EE119F2C3FAB (zone_id), INDEX IDX_5FB0EE1112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_shop_billing_data (id INT AUTO_INCREMENT NOT NULL, company VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, tax_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, country_code VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, street VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, city VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, postcode VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_shop_user (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, username VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, username_canonical VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, last_login DATETIME DEFAULT \'NULL\', password_reset_token VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, password_requested_at DATETIME DEFAULT \'NULL\', email_verification_token VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, verified_at DATETIME DEFAULT \'NULL\', locked TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT \'NULL\', credentials_expire_at DATETIME DEFAULT \'NULL\', roles LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, email_canonical VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', encoder_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_7C2B74809395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_tax_category (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', UNIQUE INDEX UNIQ_221EB0BE77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sylius_taxon (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, tree_left INT NOT NULL, tree_right INT NOT NULL, tree_level INT NOT NULL, position INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT \'NULL\', UNIQUE INDEX UNIQ_CFD811CA77153098 (code), INDEX IDX_CFD811CA727ACA70 (parent_id), INDEX IDX_CFD811CAA977936C (tree_root), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sylius_address ADD CONSTRAINT FK_B97FF0589395C3F3 FOREIGN KEY (customer_id) REFERENCES sylius_customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_channel ADD CONSTRAINT FK_16C8119E3101778E FOREIGN KEY (base_currency_id) REFERENCES sylius_currency (id)');
        $this->addSql('ALTER TABLE sylius_channel ADD CONSTRAINT FK_16C8119E743BF776 FOREIGN KEY (default_locale_id) REFERENCES sylius_locale (id)');
        $this->addSql('ALTER TABLE sylius_channel ADD CONSTRAINT FK_16C8119EA978C17 FOREIGN KEY (default_tax_zone_id) REFERENCES sylius_zone (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sylius_channel ADD CONSTRAINT FK_16C8119EB5282EDF FOREIGN KEY (shop_billing_data_id) REFERENCES sylius_shop_billing_data (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_customer ADD CONSTRAINT FK_7E82D5E6BD94FB16 FOREIGN KEY (default_address_id) REFERENCES sylius_address (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sylius_customer ADD CONSTRAINT FK_7E82D5E6D2919A68 FOREIGN KEY (customer_group_id) REFERENCES sylius_customer_group (id)');
        $this->addSql('ALTER TABLE sylius_order ADD CONSTRAINT FK_6196A1F917B24436 FOREIGN KEY (promotion_coupon_id) REFERENCES sylius_promotion_coupon (id)');
        $this->addSql('ALTER TABLE sylius_order ADD CONSTRAINT FK_6196A1F94D4CFF2B FOREIGN KEY (shipping_address_id) REFERENCES sylius_address (id)');
        $this->addSql('ALTER TABLE sylius_order ADD CONSTRAINT FK_6196A1F972F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id)');
        $this->addSql('ALTER TABLE sylius_order ADD CONSTRAINT FK_6196A1F979D0C0E4 FOREIGN KEY (billing_address_id) REFERENCES sylius_address (id)');
        $this->addSql('ALTER TABLE sylius_order ADD CONSTRAINT FK_6196A1F99395C3F3 FOREIGN KEY (customer_id) REFERENCES sylius_customer (id)');
        $this->addSql('ALTER TABLE sylius_order_item ADD CONSTRAINT FK_77B587ED3B69A9AF FOREIGN KEY (variant_id) REFERENCES sylius_product_variant (id)');
        $this->addSql('ALTER TABLE sylius_order_item ADD CONSTRAINT FK_77B587ED8D9F6D38 FOREIGN KEY (order_id) REFERENCES sylius_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_payment_method ADD CONSTRAINT FK_A75B0B0DF23D6140 FOREIGN KEY (gateway_config_id) REFERENCES sylius_gateway_config (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sylius_product ADD CONSTRAINT FK_677B9B74731E505 FOREIGN KEY (main_taxon_id) REFERENCES sylius_taxon (id)');
        $this->addSql('ALTER TABLE sylius_product_association ADD CONSTRAINT FK_48E9CDAB4584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_product_association ADD CONSTRAINT FK_48E9CDABB1E1C39 FOREIGN KEY (association_type_id) REFERENCES sylius_product_association_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_product_image ADD CONSTRAINT FK_88C64B2D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_product_option_value ADD CONSTRAINT FK_F7FF7D4BA7C41D6F FOREIGN KEY (option_id) REFERENCES sylius_product_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_product_variant ADD CONSTRAINT FK_A29B5234584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_product_variant ADD CONSTRAINT FK_A29B5239DF894ED FOREIGN KEY (tax_category_id) REFERENCES sylius_tax_category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sylius_product_variant ADD CONSTRAINT FK_A29B5239E2D1A41 FOREIGN KEY (shipping_category_id) REFERENCES sylius_shipping_category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sylius_promotion_coupon ADD CONSTRAINT FK_B04EBA85139DF194 FOREIGN KEY (promotion_id) REFERENCES sylius_promotion (id)');
        $this->addSql('ALTER TABLE sylius_shipping_method ADD CONSTRAINT FK_5FB0EE1112469DE2 FOREIGN KEY (category_id) REFERENCES sylius_shipping_category (id)');
        $this->addSql('ALTER TABLE sylius_shipping_method ADD CONSTRAINT FK_5FB0EE119DF894ED FOREIGN KEY (tax_category_id) REFERENCES sylius_tax_category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sylius_shipping_method ADD CONSTRAINT FK_5FB0EE119F2C3FAB FOREIGN KEY (zone_id) REFERENCES sylius_zone (id)');
        $this->addSql('ALTER TABLE sylius_shop_user ADD CONSTRAINT FK_7C2B74809395C3F3 FOREIGN KEY (customer_id) REFERENCES sylius_customer (id)');
        $this->addSql('ALTER TABLE sylius_taxon ADD CONSTRAINT FK_CFD811CA727ACA70 FOREIGN KEY (parent_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_taxon ADD CONSTRAINT FK_CFD811CAA977936C FOREIGN KEY (tree_root) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE metadata');
        $this->addSql('ALTER TABLE city DROP is_deliverable');
        $this->addSql('ALTER TABLE nutritionals CHANGE k_cal k_cal DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE product CHANGE picture_id picture_id INT DEFAULT NULL, CHANGE nutritionals_id nutritionals_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE tva_id tva_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE avatar_id avatar_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE username username VARCHAR(60) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE is_banned is_banned TINYINT(1) DEFAULT \'NULL\'');
    }
}
