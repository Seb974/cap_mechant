<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190927182012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD picture_id INT DEFAULT NULL, ADD nutritionals_id INT DEFAULT NULL, ADD allergens_id INT DEFAULT NULL, ADD category_id INT DEFAULT NULL, ADD tva_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADEE45BDBF FOREIGN KEY (picture_id) REFERENCES pics (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2D37E0CC FOREIGN KEY (nutritionals_id) REFERENCES nutritionals (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD711662F1 FOREIGN KEY (allergens_id) REFERENCES allergen (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4D79775F FOREIGN KEY (tva_id) REFERENCES tva (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADEE45BDBF ON product (picture_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD2D37E0CC ON product (nutritionals_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD711662F1 ON product (allergens_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD4D79775F ON product (tva_id)');
        $this->addSql('ALTER TABLE user ADD avatar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES pics (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64986383B10 ON user (avatar_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADEE45BDBF');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2D37E0CC');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD711662F1');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4D79775F');
        $this->addSql('DROP INDEX UNIQ_D34A04ADEE45BDBF ON product');
        $this->addSql('DROP INDEX UNIQ_D34A04AD2D37E0CC ON product');
        $this->addSql('DROP INDEX UNIQ_D34A04AD711662F1 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD4D79775F ON product');
        $this->addSql('ALTER TABLE product DROP picture_id, DROP nutritionals_id, DROP allergens_id, DROP category_id, DROP tva_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('DROP INDEX UNIQ_8D93D64986383B10 ON user');
        $this->addSql('ALTER TABLE user DROP avatar_id');
    }
}
