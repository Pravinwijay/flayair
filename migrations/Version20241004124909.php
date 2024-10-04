<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241004124909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aeroport (id INT AUTO_INCREMENT NOT NULL, ville_id INT NOT NULL, nom_aeroport VARCHAR(255) NOT NULL, INDEX IDX_9FB0D288A73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avion (id INT AUTO_INCREMENT NOT NULL, modele VARCHAR(255) NOT NULL, nb_places INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categ_utilisateur (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonct_categ (id INT AUTO_INCREMENT NOT NULL, categ_id INT NOT NULL, fonctionnalite_id INT NOT NULL, INDEX IDX_199C3770E8175B12 (categ_id), INDEX IDX_199C37704477C5D8 (fonctionnalite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonctionnalite (id INT AUTO_INCREMENT NOT NULL, categ_utilisateur_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_8F83CB4842070E27 (categ_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, vol_id INT NOT NULL, INDEX IDX_42C84955FB88E14F (utilisateur_id), INDEX IDX_42C849559F2BFB7A (vol_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, categ_utilisateur_id INT NOT NULL, mail VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, INDEX IDX_1D1C63B342070E27 (categ_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, cp INT NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vol (id INT AUTO_INCREMENT NOT NULL, avion_id INT NOT NULL, aeroport_depart_id INT NOT NULL, aeroport_arrive_id INT NOT NULL, num_vol VARCHAR(255) NOT NULL, duree TIME NOT NULL, heure_depart DATETIME NOT NULL, heure_arrive DATETIME NOT NULL, nb_passagers INT NOT NULL, prix_vol DOUBLE PRECISION NOT NULL, INDEX IDX_95C97EB80BBB841 (avion_id), INDEX IDX_95C97EBE3CBAF6E (aeroport_depart_id), INDEX IDX_95C97EBB9CBD76D (aeroport_arrive_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aeroport ADD CONSTRAINT FK_9FB0D288A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE fonct_categ ADD CONSTRAINT FK_199C3770E8175B12 FOREIGN KEY (categ_id) REFERENCES categ_utilisateur (id)');
        $this->addSql('ALTER TABLE fonct_categ ADD CONSTRAINT FK_199C37704477C5D8 FOREIGN KEY (fonctionnalite_id) REFERENCES fonctionnalite (id)');
        $this->addSql('ALTER TABLE fonctionnalite ADD CONSTRAINT FK_8F83CB4842070E27 FOREIGN KEY (categ_utilisateur_id) REFERENCES categ_utilisateur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849559F2BFB7A FOREIGN KEY (vol_id) REFERENCES vol (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B342070E27 FOREIGN KEY (categ_utilisateur_id) REFERENCES categ_utilisateur (id)');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EB80BBB841 FOREIGN KEY (avion_id) REFERENCES avion (id)');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EBE3CBAF6E FOREIGN KEY (aeroport_depart_id) REFERENCES aeroport (id)');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EBB9CBD76D FOREIGN KEY (aeroport_arrive_id) REFERENCES aeroport (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aeroport DROP FOREIGN KEY FK_9FB0D288A73F0036');
        $this->addSql('ALTER TABLE fonct_categ DROP FOREIGN KEY FK_199C3770E8175B12');
        $this->addSql('ALTER TABLE fonct_categ DROP FOREIGN KEY FK_199C37704477C5D8');
        $this->addSql('ALTER TABLE fonctionnalite DROP FOREIGN KEY FK_8F83CB4842070E27');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955FB88E14F');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849559F2BFB7A');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B342070E27');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB80BBB841');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EBE3CBAF6E');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EBB9CBD76D');
        $this->addSql('DROP TABLE aeroport');
        $this->addSql('DROP TABLE avion');
        $this->addSql('DROP TABLE categ_utilisateur');
        $this->addSql('DROP TABLE fonct_categ');
        $this->addSql('DROP TABLE fonctionnalite');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE vol');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
