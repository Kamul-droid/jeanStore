<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222085702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP INDEX UNIQ_E52FFDEEA76ED395, ADD INDEX IDX_E52FFDEEA76ED395 (user_id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('DROP INDEX IDX_B3BA5A5ACFFE9AD6 ON products');
        $this->addSql('ALTER TABLE products DROP orders_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP INDEX IDX_E52FFDEEA76ED395, ADD UNIQUE INDEX UNIQ_E52FFDEEA76ED395 (user_id)');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('ALTER TABLE products ADD orders_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_B3BA5A5ACFFE9AD6 ON products (orders_id)');
    }
}
