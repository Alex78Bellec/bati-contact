<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200224125342 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE distributeur (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, marque VARCHAR(255) NOT NULL, siret VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone INT NOT NULL, UNIQUE INDEX UNIQ_97E6871A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, confirmpassword VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, fabric_id INT NOT NULL, category VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, fabricant VARCHAR(255) NOT NULL, distributeur VARCHAR(255) NOT NULL, matiere VARCHAR(255) NOT NULL, INDEX IDX_29A5EC27AB43EC50 (fabric_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_distributeur (produit_id INT NOT NULL, distributeur_id INT NOT NULL, INDEX IDX_E3D5370CF347EFB (produit_id), INDEX IDX_E3D5370C29EB7ACA (distributeur_id), PRIMARY KEY(produit_id, distributeur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fabricant (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, marque VARCHAR(255) NOT NULL, siret INT NOT NULL, ville VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone INT NOT NULL, UNIQUE INDEX UNIQ_D740A269A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE distributeur ADD CONSTRAINT FK_97E6871A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27AB43EC50 FOREIGN KEY (fabric_id) REFERENCES fabricant (id)');
        $this->addSql('ALTER TABLE produit_distributeur ADD CONSTRAINT FK_E3D5370CF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_distributeur ADD CONSTRAINT FK_E3D5370C29EB7ACA FOREIGN KEY (distributeur_id) REFERENCES distributeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fabricant ADD CONSTRAINT FK_D740A269A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produit_distributeur DROP FOREIGN KEY FK_E3D5370C29EB7ACA');
        $this->addSql('ALTER TABLE distributeur DROP FOREIGN KEY FK_97E6871A76ED395');
        $this->addSql('ALTER TABLE fabricant DROP FOREIGN KEY FK_D740A269A76ED395');
        $this->addSql('ALTER TABLE produit_distributeur DROP FOREIGN KEY FK_E3D5370CF347EFB');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27AB43EC50');
        $this->addSql('DROP TABLE distributeur');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produit_distributeur');
        $this->addSql('DROP TABLE fabricant');
    }
}
