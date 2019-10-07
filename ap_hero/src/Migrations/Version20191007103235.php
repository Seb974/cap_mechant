<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191007103235 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE metadata DROP phone_number, CHANGE field field VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE picture_id picture_id INT DEFAULT NULL, CHANGE nutritionals_id nutritionals_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE tva_id tva_id INT DEFAULT NULL, CHANGE supplier_id supplier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE avatar_id avatar_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE username username VARCHAR(60) DEFAULT NULL, CHANGE is_banned is_banned TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE variant CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_item CHANGE cart_id cart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nutritionals CHANGE k_j k_j DOUBLE PRECISION DEFAULT NULL, CHANGE k_cal k_cal DOUBLE PRECISION DEFAULT NULL, CHANGE protein protein DOUBLE PRECISION DEFAULT NULL, CHANGE carbohydrates carbohydrates DOUBLE PRECISION DEFAULT NULL, CHANGE sugar sugar DOUBLE PRECISION DEFAULT NULL, CHANGE fat fat DOUBLE PRECISION DEFAULT NULL, CHANGE trans_ag trans_ag DOUBLE PRECISION DEFAULT NULL, CHANGE salt salt DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE cart CHANGE user_id user_id INT DEFAULT NULL, CHANGE total_tax total_tax DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart CHANGE user_id user_id INT DEFAULT NULL, CHANGE total_tax total_tax DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE cart_item CHANGE cart_id cart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE metadata ADD phone_number INT DEFAULT NULL, CHANGE field field VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE nutritionals CHANGE k_j k_j DOUBLE PRECISION DEFAULT \'NULL\', CHANGE k_cal k_cal DOUBLE PRECISION DEFAULT \'NULL\', CHANGE protein protein DOUBLE PRECISION DEFAULT \'NULL\', CHANGE carbohydrates carbohydrates DOUBLE PRECISION DEFAULT \'NULL\', CHANGE sugar sugar DOUBLE PRECISION DEFAULT \'NULL\', CHANGE fat fat DOUBLE PRECISION DEFAULT \'NULL\', CHANGE trans_ag trans_ag DOUBLE PRECISION DEFAULT \'NULL\', CHANGE salt salt DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE product CHANGE picture_id picture_id INT DEFAULT NULL, CHANGE nutritionals_id nutritionals_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE tva_id tva_id INT DEFAULT NULL, CHANGE supplier_id supplier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE avatar_id avatar_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE username username VARCHAR(60) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE is_banned is_banned TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE variant CHANGE product_id product_id INT DEFAULT NULL');
    }
}
