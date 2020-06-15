<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200323233323 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE appareil (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, type VARCHAR(100) NOT NULL, modele VARCHAR(100) NOT NULL, capacite VARCHAR(100) NOT NULL, imei VARCHAR(100) DEFAULT NULL, serial VARCHAR(100) NOT NULL, mac VARCHAR(100) DEFAULT NULL, description LONGTEXT NOT NULL, technicals LONGTEXT NOT NULL, statut VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_456A601AB8179F8 (imei), UNIQUE INDEX UNIQ_456A601AD374C9DC (serial), UNIQUE INDEX UNIQ_456A601A1713EB65 (mac), INDEX IDX_456A601AFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, activation_token VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appareil ADD CONSTRAINT FK_456A601AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appareil DROP FOREIGN KEY FK_456A601AFB88E14F');
        $this->addSql('DROP TABLE appareil');
        $this->addSql('DROP TABLE utilisateur');
    }
}
