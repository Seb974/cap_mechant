<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190930152558 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE allergen (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, picture_id INT DEFAULT NULL, nutritionals_id INT DEFAULT NULL, category_id INT DEFAULT NULL, tva_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_D34A04ADEE45BDBF (picture_id), UNIQUE INDEX UNIQ_D34A04AD2D37E0CC (nutritionals_id), INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD4D79775F (tva_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_allergen (product_id INT NOT NULL, allergen_id INT NOT NULL, INDEX IDX_EE0F62594584665A (product_id), INDEX IDX_EE0F62596E775A4A (allergen_id), PRIMARY KEY(product_id, allergen_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_4B3656604584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tva (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, taux DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_item (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, INDEX IDX_F0FE25274584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, zip_code INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nutritionals (id INT AUTO_INCREMENT NOT NULL, k_j DOUBLE PRECISION NOT NULL, k_cal DOUBLE PRECISION DEFAULT NULL, protein DOUBLE PRECISION NOT NULL, carbohydrates DOUBLE PRECISION NOT NULL, sugar DOUBLE PRECISION NOT NULL, fat DOUBLE PRECISION NOT NULL, trans_ag DOUBLE PRECISION NOT NULL, salt DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pics (id INT AUTO_INCREMENT NOT NULL, b64 VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, avatar_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(60) DEFAULT NULL, is_banned TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64986383B10 (avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADEE45BDBF FOREIGN KEY (picture_id) REFERENCES pics (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2D37E0CC FOREIGN KEY (nutritionals_id) REFERENCES nutritionals (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4D79775F FOREIGN KEY (tva_id) REFERENCES tva (id)');
        $this->addSql('ALTER TABLE product_allergen ADD CONSTRAINT FK_EE0F62594584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_allergen ADD CONSTRAINT FK_EE0F62596E775A4A FOREIGN KEY (allergen_id) REFERENCES allergen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B3656604584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25274584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES pics (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_allergen DROP FOREIGN KEY FK_EE0F62596E775A4A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product_allergen DROP FOREIGN KEY FK_EE0F62594584665A');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656604584665A');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25274584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4D79775F');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2D37E0CC');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADEE45BDBF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('DROP TABLE allergen');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_allergen');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE tva');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE nutritionals');
        $this->addSql('DROP TABLE pics');
        $this->addSql('DROP TABLE user');
    }
}
