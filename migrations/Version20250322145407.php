<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250322145407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE service_log_id_seq CASCADE');
        $this->addSql('CREATE TABLE service_logs (id SERIAL NOT NULL, service_name VARCHAR(255) NOT NULL, log_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, http_verb VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, http_version VARCHAR(255) DEFAULT NULL, status_code INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE service_log');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE service_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE service_log (id SERIAL NOT NULL, service_name VARCHAR(255) NOT NULL, log_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, http_verb VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, http_version VARCHAR(255) DEFAULT NULL, status_code INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE service_logs');
    }
}
