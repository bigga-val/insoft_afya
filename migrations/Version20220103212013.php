<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103212013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE choix_medecin (id INT AUTO_INCREMENT NOT NULL, medecin_service_hopital_id INT NOT NULL, patient_id INT NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, INDEX IDX_3D06ABBFB0BEF282 (medecin_service_hopital_id), INDEX IDX_3D06ABBF6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE choix_medecin ADD CONSTRAINT FK_3D06ABBFB0BEF282 FOREIGN KEY (medecin_service_hopital_id) REFERENCES medecin_service_hopital (id)');
        $this->addSql('ALTER TABLE choix_medecin ADD CONSTRAINT FK_3D06ABBF6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE choix_medecin');
    }
}
