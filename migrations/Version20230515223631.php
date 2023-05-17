<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515223631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE solution (id INT AUTO_INCREMENT NOT NULL, developer_id INT DEFAULT NULL, problem_id INT DEFAULT NULL, content_s VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_9F3329DB64DD9267 (developer_id), INDEX IDX_9F3329DBA0DCED86 (problem_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE solution ADD CONSTRAINT FK_9F3329DB64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('ALTER TABLE solution ADD CONSTRAINT FK_9F3329DBA0DCED86 FOREIGN KEY (problem_id) REFERENCES problem (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solution DROP FOREIGN KEY FK_9F3329DB64DD9267');
        $this->addSql('ALTER TABLE solution DROP FOREIGN KEY FK_9F3329DBA0DCED86');
        $this->addSql('DROP TABLE solution');
    }
}
