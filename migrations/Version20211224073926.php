<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211224073926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders_qty (id INT AUTO_INCREMENT NOT NULL, prodqty INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products ADD orders_qty_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A5349F32D FOREIGN KEY (orders_qty_id) REFERENCES orders_qty (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A5349F32D ON products (orders_qty_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A5349F32D');
        $this->addSql('DROP TABLE orders_qty');
        $this->addSql('DROP INDEX IDX_B3BA5A5A5349F32D ON products');
        $this->addSql('ALTER TABLE products DROP orders_qty_id');
    }
}
