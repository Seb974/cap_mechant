<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191008074655 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, supplier_id INT NOT NULL, cart_item_id INT NOT NULL, payment_id INT NOT NULL, payment_type VARCHAR(60) NOT NULL, total_to_pay_ttc DOUBLE PRECISION NOT NULL, total_to_pay_ht DOUBLE PRECISION NOT NULL, total_tax DOUBLE PRECISION NOT NULL, order_status VARCHAR(60) NOT NULL, INDEX IDX_F5299398A76ED395 (user_id), UNIQUE INDEX UNIQ_F52993982ADD6D8C (supplier_id), UNIQUE INDEX UNIQ_F5299398E9B59A59 (cart_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993982ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398E9B59A59 FOREIGN KEY (cart_item_id) REFERENCES cart_item (id)');
        $this->addSql('DROP TABLE cart_cart_item');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cart_cart_item (cart_id INT NOT NULL, cart_item_id INT NOT NULL, INDEX IDX_2A0002B81AD5CDBF (cart_id), INDEX IDX_2A0002B8E9B59A59 (cart_item_id), PRIMARY KEY(cart_id, cart_item_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cart_cart_item ADD CONSTRAINT FK_2A0002B81AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_cart_item ADD CONSTRAINT FK_2A0002B8E9B59A59 FOREIGN KEY (cart_item_id) REFERENCES cart_item (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE `order`');
    }
}
