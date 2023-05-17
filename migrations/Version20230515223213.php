<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515223213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE problem (id INT AUTO_INCREMENT NOT NULL, developeur_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_D7E7CCC83E5F2F39 (developeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE problem ADD CONSTRAINT FK_D7E7CCC83E5F2F39 FOREIGN KEY (developeur_id) REFERENCES developer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE problem DROP FOREIGN KEY FK_D7E7CCC83E5F2F39');
        $this->addSql('DROP TABLE problem');
    }
}
