<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103192704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medecin_service_hopital (id INT AUTO_INCREMENT NOT NULL, medecin_id INT NOT NULL, service_hopital_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', create_by VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, INDEX IDX_215921604F31A84 (medecin_id), INDEX IDX_215921605A5E8626 (service_hopital_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medecin_service_hopital ADD CONSTRAINT FK_215921604F31A84 FOREIGN KEY (medecin_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE medecin_service_hopital ADD CONSTRAINT FK_215921605A5E8626 FOREIGN KEY (service_hopital_id) REFERENCES service_hopital (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE medecin_service_hopital');
    }
}
