<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220206081224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hopital (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, nom_hopital VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, no_urgence VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8718F2C217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medecin_service_hopital (id INT AUTO_INCREMENT NOT NULL, medecin_id INT NOT NULL, service_hopital_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', create_by VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, INDEX IDX_215921604F31A84 (medecin_id), INDEX IDX_215921605A5E8626 (service_hopital_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, nom_service VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_hopital (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, hopital_id INT NOT NULL, created_by VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) DEFAULT NULL, INDEX IDX_C7F5DDB0ED5CA9E6 (service_id), INDEX IDX_C7F5DDB0CC0FBF92 (hopital_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hopital ADD CONSTRAINT FK_8718F2C217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE medecin_service_hopital ADD CONSTRAINT FK_215921604F31A84 FOREIGN KEY (medecin_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE medecin_service_hopital ADD CONSTRAINT FK_215921605A5E8626 FOREIGN KEY (service_hopital_id) REFERENCES service_hopital (id)');
        $this->addSql('ALTER TABLE service_hopital ADD CONSTRAINT FK_C7F5DDB0ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service_hopital ADD CONSTRAINT FK_C7F5DDB0CC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id)');
        $this->addSql('ALTER TABLE choix_medecin ADD CONSTRAINT FK_3D06ABBFB0BEF282 FOREIGN KEY (medecin_service_hopital_id) REFERENCES medecin_service_hopital (id)');
        $this->addSql('ALTER TABLE choix_medecin ADD CONSTRAINT FK_3D06ABBF6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FCD3BC37 FOREIGN KEY (choix_medecin_id) REFERENCES choix_medecin (id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36A217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176219B36A3 FOREIGN KEY (user_person_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA8CD3BC37 FOREIGN KEY (choix_medecin_id) REFERENCES choix_medecin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_hopital DROP FOREIGN KEY FK_C7F5DDB0CC0FBF92');
        $this->addSql('ALTER TABLE choix_medecin DROP FOREIGN KEY FK_3D06ABBFB0BEF282');
        $this->addSql('ALTER TABLE service_hopital DROP FOREIGN KEY FK_C7F5DDB0ED5CA9E6');
        $this->addSql('ALTER TABLE medecin_service_hopital DROP FOREIGN KEY FK_215921605A5E8626');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FA76ED395');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176219B36A3');
        $this->addSql('DROP TABLE hopital');
        $this->addSql('DROP TABLE medecin_service_hopital');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_hopital');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('ALTER TABLE choix_medecin DROP FOREIGN KEY FK_3D06ABBF6B899279');
        $this->addSql('ALTER TABLE choix_medecin CHANGE created_by created_by VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FCD3BC37');
        $this->addSql('ALTER TABLE discussion CHANGE created_by created_by VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE message message VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36A217BBB47');
        $this->addSql('ALTER TABLE doctor CHANGE matricule matricule VARCHAR(25) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(25) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE profile_picture profile_picture VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE created_by created_by VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB217BBB47');
        $this->addSql('ALTER TABLE patient CHANGE adress adress VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE created_by created_by VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE picture picture VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE person CHANGE nom_postnom nom_postnom VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse_physique adresse_physique VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(20) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE created_by created_by VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE photo_profile photo_profile VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA8CD3BC37');
        $this->addSql('ALTER TABLE rendezvous CHANGE motif motif VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE created_by created_by VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
