<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200722080207 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, rue VARCHAR(255) NOT NULL, ville VARCHAR(120) NOT NULL, code_postal VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(120) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE propriete (id INT AUTO_INCREMENT NOT NULL, adresse_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(500) NOT NULL, surface INT NOT NULL, nb_pieces INT NOT NULL, etage INT DEFAULT NULL, nb_chambres INT NOT NULL, vendue TINYINT(1) DEFAULT \'0\' NOT NULL, date_ajout DATETIME NOT NULL, prix INT NOT NULL, INDEX IDX_73A85B934DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE propriete_option_propriete (propriete_id INT NOT NULL, option_propriete_id INT NOT NULL, INDEX IDX_F8F2405318566CAF (propriete_id), INDEX IDX_F8F24053D47C2F63 (option_propriete_id), PRIMARY KEY(propriete_id, option_propriete_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(30) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE propriete ADD CONSTRAINT FK_73A85B934DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE propriete_option_propriete ADD CONSTRAINT FK_F8F2405318566CAF FOREIGN KEY (propriete_id) REFERENCES propriete (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE propriete_option_propriete ADD CONSTRAINT FK_F8F24053D47C2F63 FOREIGN KEY (option_propriete_id) REFERENCES `option` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE propriete DROP FOREIGN KEY FK_73A85B934DE7DC5C');
        $this->addSql('ALTER TABLE propriete_option_propriete DROP FOREIGN KEY FK_F8F24053D47C2F63');
        $this->addSql('ALTER TABLE propriete_option_propriete DROP FOREIGN KEY FK_F8F2405318566CAF');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE propriete');
        $this->addSql('DROP TABLE propriete_option_propriete');
        $this->addSql('DROP TABLE user');
    }
}
