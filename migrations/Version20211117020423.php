<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117020423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, nom_service VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_hopital (id INT AUTO_INCREMENT NOT NULL, created_by VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_hopital_service (service_hopital_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_975D73EC5A5E8626 (service_hopital_id), INDEX IDX_975D73ECED5CA9E6 (service_id), PRIMARY KEY(service_hopital_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_hopital_hopital (service_hopital_id INT NOT NULL, hopital_id INT NOT NULL, INDEX IDX_7EB166125A5E8626 (service_hopital_id), INDEX IDX_7EB16612CC0FBF92 (hopital_id), PRIMARY KEY(service_hopital_id, hopital_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_hopital_service ADD CONSTRAINT FK_975D73EC5A5E8626 FOREIGN KEY (service_hopital_id) REFERENCES service_hopital (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_hopital_service ADD CONSTRAINT FK_975D73ECED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_hopital_hopital ADD CONSTRAINT FK_7EB166125A5E8626 FOREIGN KEY (service_hopital_id) REFERENCES service_hopital (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_hopital_hopital ADD CONSTRAINT FK_7EB16612CC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_hopital_service DROP FOREIGN KEY FK_975D73ECED5CA9E6');
        $this->addSql('ALTER TABLE service_hopital_service DROP FOREIGN KEY FK_975D73EC5A5E8626');
        $this->addSql('ALTER TABLE service_hopital_hopital DROP FOREIGN KEY FK_7EB166125A5E8626');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_hopital');
        $this->addSql('DROP TABLE service_hopital_service');
        $this->addSql('DROP TABLE service_hopital_hopital');
    }
}
