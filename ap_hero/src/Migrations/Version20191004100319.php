<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191004100319 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE variant (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, name VARCHAR(60) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_F143BFAD4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE city ADD is_deliverable TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25274584665A');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25274584665A FOREIGN KEY (product_id) REFERENCES variant (id)');
        $this->addSql('ALTER TABLE metadata CHANGE facturation_address facturation_address VARCHAR(255) DEFAULT NULL, CHANGE delivery_address delivery_address VARCHAR(255) DEFAULT NULL, CHANGE phone_number phone_number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product DROP price, CHANGE picture_id picture_id INT DEFAULT NULL, CHANGE nutritionals_id nutritionals_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE tva_id tva_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656604584665A');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B3656604584665A FOREIGN KEY (product_id) REFERENCES variant (id)');
        $this->addSql('ALTER TABLE user CHANGE avatar_id avatar_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL, CHANGE username username VARCHAR(60) DEFAULT NULL, CHANGE is_banned is_banned TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE nutritionals CHANGE k_cal k_cal DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25274584665A');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656604584665A');
        $this->addSql('DROP TABLE variant');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25274584665A');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25274584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE city DROP is_deliverable');
        $this->addSql('ALTER TABLE metadata CHANGE facturation_address facturation_address VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE delivery_address delivery_address VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE phone_number phone_number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nutritionals CHANGE k_cal k_cal DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE product ADD price DOUBLE PRECISION DEFAULT \'NULL\', CHANGE picture_id picture_id INT DEFAULT NULL, CHANGE nutritionals_id nutritionals_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE tva_id tva_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656604584665A');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B3656604584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE user CHANGE avatar_id avatar_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE username username VARCHAR(60) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE is_banned is_banned TINYINT(1) DEFAULT \'NULL\'');
    }
}
