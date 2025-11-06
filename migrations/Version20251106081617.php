<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251106081617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pikmin ADD color_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pikmin ADD CONSTRAINT FK_9CDF0D9E7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('CREATE INDEX IDX_9CDF0D9E7ADA1FB5 ON pikmin (color_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pikmin DROP FOREIGN KEY FK_9CDF0D9E7ADA1FB5');
        $this->addSql('DROP INDEX IDX_9CDF0D9E7ADA1FB5 ON pikmin');
        $this->addSql('ALTER TABLE pikmin DROP color_id');
    }
}
