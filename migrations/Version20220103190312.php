<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103190312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_hopital DROP INDEX UNIQ_C7F5DDB0ED5CA9E6, ADD INDEX IDX_C7F5DDB0ED5CA9E6 (service_id)');
        $this->addSql('ALTER TABLE service_hopital DROP INDEX UNIQ_C7F5DDB0CC0FBF92, ADD INDEX IDX_C7F5DDB0CC0FBF92 (hopital_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_hopital DROP INDEX IDX_C7F5DDB0ED5CA9E6, ADD UNIQUE INDEX UNIQ_C7F5DDB0ED5CA9E6 (service_id)');
        $this->addSql('ALTER TABLE service_hopital DROP INDEX IDX_C7F5DDB0CC0FBF92, ADD UNIQUE INDEX UNIQ_C7F5DDB0CC0FBF92 (hopital_id)');
    }
}
