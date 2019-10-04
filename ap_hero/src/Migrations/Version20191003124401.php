<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191003124401 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE metadata (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, city_id INT NOT NULL, facturation_address VARCHAR(255) DEFAULT NULL, delivery_address VARCHAR(255) DEFAULT NULL, phone_number INT DEFAULT NULL, UNIQUE INDEX UNIQ_4F143414A76ED395 (user_id), INDEX IDX_4F1434148BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE metadata ADD CONSTRAINT FK_4F143414A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE metadata ADD CONSTRAINT FK_4F1434148BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE user CHANGE avatar_id avatar_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE username username VARCHAR(60) DEFAULT NULL, CHANGE is_banned is_banned TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE picture_id picture_id INT DEFAULT NULL, CHANGE nutritionals_id nutritionals_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE tva_id tva_id INT DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE nutritionals CHANGE k_cal k_cal DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE metadata');
        $this->addSql('ALTER TABLE nutritionals CHANGE k_cal k_cal DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE product CHANGE picture_id picture_id INT DEFAULT NULL, CHANGE nutritionals_id nutritionals_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE tva_id tva_id INT DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE avatar_id avatar_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE username username VARCHAR(60) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE is_banned is_banned TINYINT(1) DEFAULT \'NULL\'');
    }
}
