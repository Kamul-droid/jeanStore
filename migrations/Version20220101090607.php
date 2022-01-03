<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220101090607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_qty DROP FOREIGN KEY FK_28D7FA00FCDAEAAA');
        $this->addSql('DROP INDEX IDX_28D7FA00FCDAEAAA ON product_qty');
        $this->addSql('ALTER TABLE product_qty CHANGE order_id_id ord_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_qty ADD CONSTRAINT FK_28D7FA00E636D3F5 FOREIGN KEY (ord_id) REFERENCES orders (id)');
        $this->addSql('CREATE INDEX IDX_28D7FA00E636D3F5 ON product_qty (ord_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_qty DROP FOREIGN KEY FK_28D7FA00E636D3F5');
        $this->addSql('DROP INDEX IDX_28D7FA00E636D3F5 ON product_qty');
        $this->addSql('ALTER TABLE product_qty CHANGE ord_id order_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_qty ADD CONSTRAINT FK_28D7FA00FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES orders (id)');
        $this->addSql('CREATE INDEX IDX_28D7FA00FCDAEAAA ON product_qty (order_id_id)');
    }
}
