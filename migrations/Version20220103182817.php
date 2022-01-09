<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103182817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE service_hopital_hopital');
        $this->addSql('DROP TABLE service_hopital_service');
        $this->addSql('ALTER TABLE service_hopital ADD service_id INT NOT NULL, ADD hopital_id INT NOT NULL');
        $this->addSql('ALTER TABLE service_hopital ADD CONSTRAINT FK_C7F5DDB0ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service_hopital ADD CONSTRAINT FK_C7F5DDB0CC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7F5DDB0ED5CA9E6 ON service_hopital (service_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7F5DDB0CC0FBF92 ON service_hopital (hopital_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_hopital_hopital (service_hopital_id INT NOT NULL, hopital_id INT NOT NULL, INDEX IDX_7EB166125A5E8626 (service_hopital_id), INDEX IDX_7EB16612CC0FBF92 (hopital_id), PRIMARY KEY(service_hopital_id, hopital_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE service_hopital_service (service_hopital_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_975D73EC5A5E8626 (service_hopital_id), INDEX IDX_975D73ECED5CA9E6 (service_id), PRIMARY KEY(service_hopital_id, service_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE service_hopital_hopital ADD CONSTRAINT FK_7EB166125A5E8626 FOREIGN KEY (service_hopital_id) REFERENCES service_hopital (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_hopital_hopital ADD CONSTRAINT FK_7EB16612CC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_hopital_service ADD CONSTRAINT FK_975D73EC5A5E8626 FOREIGN KEY (service_hopital_id) REFERENCES service_hopital (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_hopital_service ADD CONSTRAINT FK_975D73ECED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_hopital DROP FOREIGN KEY FK_C7F5DDB0ED5CA9E6');
        $this->addSql('ALTER TABLE service_hopital DROP FOREIGN KEY FK_C7F5DDB0CC0FBF92');
        $this->addSql('DROP INDEX UNIQ_C7F5DDB0ED5CA9E6 ON service_hopital');
        $this->addSql('DROP INDEX UNIQ_C7F5DDB0CC0FBF92 ON service_hopital');
        $this->addSql('ALTER TABLE service_hopital DROP service_id, DROP hopital_id');
    }
}
