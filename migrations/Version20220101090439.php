<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220101090439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_qty (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, order_id_id INT DEFAULT NULL, qunatity INT NOT NULL, INDEX IDX_28D7FA004584665A (product_id), INDEX IDX_28D7FA00FCDAEAAA (order_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_qty ADD CONSTRAINT FK_28D7FA004584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE product_qty ADD CONSTRAINT FK_28D7FA00FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES orders (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product_qty');
    }
}
