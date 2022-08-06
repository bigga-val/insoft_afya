<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220410061835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE choix_medecin (id INT AUTO_INCREMENT NOT NULL, medecin_service_hopital_id INT NOT NULL, patient_id INT NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, INDEX IDX_3D06ABBFB0BEF282 (medecin_service_hopital_id), INDEX IDX_3D06ABBF6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, choix_medecin_id INT NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, INDEX IDX_C0B9F90FA76ED395 (user_id), INDEX IDX_C0B9F90FCD3BC37 (choix_medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, matricule VARCHAR(25) DEFAULT NULL, telephone VARCHAR(25) DEFAULT NULL, profile_picture VARCHAR(255) DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1FC0F36A217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, adress VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1ADAD7EB217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, user_person_id INT NOT NULL, nom_postnom VARCHAR(255) DEFAULT NULL, adresse_physique VARCHAR(255) DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) NOT NULL, photo_profile VARCHAR(255) DEFAULT NULL, edited_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_34DCD176219B36A3 (user_person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendezvous (id INT AUTO_INCREMENT NOT NULL, choix_medecin_id INT DEFAULT NULL, motif VARCHAR(255) DEFAULT NULL, heure_rendezvous DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, INDEX IDX_C09A9BA8CD3BC37 (choix_medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE choix_medecin ADD CONSTRAINT FK_3D06ABBFB0BEF282 FOREIGN KEY (medecin_service_hopital_id) REFERENCES medecin_service_hopital (id)');
        $this->addSql('ALTER TABLE choix_medecin ADD CONSTRAINT FK_3D06ABBF6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FCD3BC37 FOREIGN KEY (choix_medecin_id) REFERENCES choix_medecin (id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36A217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176219B36A3 FOREIGN KEY (user_person_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA8CD3BC37 FOREIGN KEY (choix_medecin_id) REFERENCES choix_medecin (id)');
        $this->addSql('ALTER TABLE hopital ADD CONSTRAINT FK_8718F2C217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE medecin_service_hopital ADD CONSTRAINT FK_215921604F31A84 FOREIGN KEY (medecin_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE medecin_service_hopital ADD CONSTRAINT FK_215921605A5E8626 FOREIGN KEY (service_hopital_id) REFERENCES service_hopital (id)');
        $this->addSql('ALTER TABLE service_hopital ADD CONSTRAINT FK_C7F5DDB0ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service_hopital ADD CONSTRAINT FK_C7F5DDB0CC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FCD3BC37');
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA8CD3BC37');
        $this->addSql('ALTER TABLE medecin_service_hopital DROP FOREIGN KEY FK_215921604F31A84');
        $this->addSql('ALTER TABLE choix_medecin DROP FOREIGN KEY FK_3D06ABBF6B899279');
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36A217BBB47');
        $this->addSql('ALTER TABLE hopital DROP FOREIGN KEY FK_8718F2C217BBB47');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB217BBB47');
        $this->addSql('DROP TABLE choix_medecin');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE rendezvous');
        $this->addSql('ALTER TABLE hopital CHANGE nom_hopital nom_hopital VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE no_urgence no_urgence VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE medecin_service_hopital DROP FOREIGN KEY FK_215921605A5E8626');
        $this->addSql('ALTER TABLE medecin_service_hopital CHANGE create_by create_by VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE service CHANGE nom_service nom_service VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE created_by created_by VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE service_hopital DROP FOREIGN KEY FK_C7F5DDB0ED5CA9E6');
        $this->addSql('ALTER TABLE service_hopital DROP FOREIGN KEY FK_C7F5DDB0CC0FBF92');
        $this->addSql('ALTER TABLE service_hopital CHANGE created_by created_by VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user` CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE created_by created_by VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
