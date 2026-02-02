<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260201195629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE technical (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE painting ADD technical_id INT NOT NULL, ADD category_id INT NOT NULL, DROP technical, DROP category');
        $this->addSql('ALTER TABLE painting ADD CONSTRAINT FK_66B9EBA0B9FC167E FOREIGN KEY (technical_id) REFERENCES technical (id)');
        $this->addSql('ALTER TABLE painting ADD CONSTRAINT FK_66B9EBA012469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_66B9EBA0B9FC167E ON painting (technical_id)');
        $this->addSql('CREATE INDEX IDX_66B9EBA012469DE2 ON painting (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE technical');
        $this->addSql('ALTER TABLE painting DROP FOREIGN KEY FK_66B9EBA0B9FC167E');
        $this->addSql('ALTER TABLE painting DROP FOREIGN KEY FK_66B9EBA012469DE2');
        $this->addSql('DROP INDEX IDX_66B9EBA0B9FC167E ON painting');
        $this->addSql('DROP INDEX IDX_66B9EBA012469DE2 ON painting');
        $this->addSql('ALTER TABLE painting ADD technical VARCHAR(100) NOT NULL, ADD category VARCHAR(100) NOT NULL, DROP technical_id, DROP category_id');
    }
}
