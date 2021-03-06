<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191010044248 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE variant (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(60) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_F143BFAD4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, cart_item_id INT NOT NULL, supplier_id INT NOT NULL, payment_id VARCHAR(60) NOT NULL, payment_type VARCHAR(60) NOT NULL, total_to_pay_ttc DOUBLE PRECISION NOT NULL, total_to_pay_ht DOUBLE PRECISION NOT NULL, total_tax DOUBLE PRECISION NOT NULL, order_status VARCHAR(255) NOT NULL, tax_rate DOUBLE PRECISION NOT NULL, internal_id VARCHAR(64) NOT NULL, cart_id INT NOT NULL, pay_date_time DATETIME DEFAULT NULL, INDEX IDX_E52FFDEEA76ED395 (user_id), UNIQUE INDEX UNIQ_E52FFDEEE9B59A59 (cart_item_id), INDEX IDX_E52FFDEE2ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, address LONGTEXT NOT NULL, preparation_period TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE allergen (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metadata (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, field VARCHAR(255) DEFAULT NULL, INDEX IDX_4F143414A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, zip_code INT NOT NULL, name VARCHAR(255) NOT NULL, is_deliverable TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nutritionals (id INT AUTO_INCREMENT NOT NULL, k_j DOUBLE PRECISION DEFAULT NULL, k_cal DOUBLE PRECISION DEFAULT NULL, protein DOUBLE PRECISION DEFAULT NULL, carbohydrates DOUBLE PRECISION DEFAULT NULL, sugar DOUBLE PRECISION DEFAULT NULL, fat DOUBLE PRECISION DEFAULT NULL, trans_ag DOUBLE PRECISION DEFAULT NULL, salt DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pics (id INT AUTO_INCREMENT NOT NULL, b64 VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, picture_id INT DEFAULT NULL, nutritionals_id INT DEFAULT NULL, category_id INT DEFAULT NULL, tva_id INT DEFAULT NULL, supplier_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_D34A04ADEE45BDBF (picture_id), UNIQUE INDEX UNIQ_D34A04AD2D37E0CC (nutritionals_id), INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD4D79775F (tva_id), INDEX IDX_D34A04AD2ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_allergen (product_id INT NOT NULL, allergen_id INT NOT NULL, INDEX IDX_EE0F62594584665A (product_id), INDEX IDX_EE0F62596E775A4A (allergen_id), PRIMARY KEY(product_id, allergen_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, avatar_id INT DEFAULT NULL, supplier_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(60) DEFAULT NULL, is_banned TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64986383B10 (avatar_id), INDEX IDX_8D93D6492ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tva (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, taux DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, total_to_pay DOUBLE PRECISION NOT NULL, is_validated TINYINT(1) NOT NULL, total_tax DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_BA388B7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_4B3656604584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_item (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, cart_id INT DEFAULT NULL, orders_id INT DEFAULT NULL, quantity DOUBLE PRECISION NOT NULL, is_paid TINYINT(1) NOT NULL, INDEX IDX_F0FE25274584665A (product_id), INDEX IDX_F0FE25271AD5CDBF (cart_id), INDEX IDX_F0FE2527CFFE9AD6 (orders_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cron_job (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, command VARCHAR(1024) NOT NULL, schedule VARCHAR(191) NOT NULL, description VARCHAR(191) NOT NULL, enabled TINYINT(1) NOT NULL, UNIQUE INDEX un_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cron_report (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, run_at DATETIME NOT NULL, run_time DOUBLE PRECISION NOT NULL, exit_code INT NOT NULL, output LONGTEXT NOT NULL, INDEX IDX_B6C6A7F5BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEE9B59A59 FOREIGN KEY (cart_item_id) REFERENCES cart_item (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE metadata ADD CONSTRAINT FK_4F143414A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADEE45BDBF FOREIGN KEY (picture_id) REFERENCES pics (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2D37E0CC FOREIGN KEY (nutritionals_id) REFERENCES nutritionals (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4D79775F FOREIGN KEY (tva_id) REFERENCES tva (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE product_allergen ADD CONSTRAINT FK_EE0F62594584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_allergen ADD CONSTRAINT FK_EE0F62596E775A4A FOREIGN KEY (allergen_id) REFERENCES allergen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES pics (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B3656604584665A FOREIGN KEY (product_id) REFERENCES variant (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25274584665A FOREIGN KEY (product_id) REFERENCES variant (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25271AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE cron_report ADD CONSTRAINT FK_B6C6A7F5BE04EA9 FOREIGN KEY (job_id) REFERENCES cron_job (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656604584665A');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25274584665A');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE2527CFFE9AD6');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE2ADD6D8C');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2ADD6D8C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492ADD6D8C');
        $this->addSql('ALTER TABLE product_allergen DROP FOREIGN KEY FK_EE0F62596E775A4A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2D37E0CC');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADEE45BDBF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD4584665A');
        $this->addSql('ALTER TABLE product_allergen DROP FOREIGN KEY FK_EE0F62594584665A');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('ALTER TABLE metadata DROP FOREIGN KEY FK_4F143414A76ED395');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4D79775F');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25271AD5CDBF');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEE9B59A59');
        $this->addSql('ALTER TABLE cron_report DROP FOREIGN KEY FK_B6C6A7F5BE04EA9');
        $this->addSql('DROP TABLE variant');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE allergen');
        $this->addSql('DROP TABLE metadata');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE nutritionals');
        $this->addSql('DROP TABLE pics');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_allergen');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE tva');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE cron_job');
        $this->addSql('DROP TABLE cron_report');
    }
}
