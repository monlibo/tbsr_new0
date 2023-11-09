<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103065601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent (identifiant_agent VARCHAR(33) NOT NULL, npi VARCHAR(10) DEFAULT NULL, ifu VARCHAR(13) DEFAULT NULL, matricule VARCHAR(6) DEFAULT NULL, nom VARCHAR(64) NOT NULL, prenom VARCHAR(128) NOT NULL, nomdejeunefille VARCHAR(64) DEFAULT NULL, sexe VARCHAR(8) NOT NULL, date_naissance DATE DEFAULT NULL, lieu_naissance VARCHAR(64) DEFAULT NULL, fullname VARCHAR(255) DEFAULT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(identifiant_agent)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bailleur (id INT AUTO_INCREMENT NOT NULL, libelle LONGTEXT NOT NULL, description LONGTEXT NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devises (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, taux DOUBLE PRECISION NOT NULL, libelle VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_by VARCHAR(255) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_by VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D21EDEA77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) NOT NULL, updated_by VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_by VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_900D5BD77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mouchard (id INT AUTO_INCREMENT NOT NULL, entite VARCHAR(50) DEFAULT NULL, id_entite VARCHAR(255) NOT NULL, libelle_entite VARCHAR(255) DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, profil VARCHAR(50) DEFAULT NULL, observations LONGTEXT DEFAULT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_visibilite (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(100) NOT NULL, libelle VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by INT NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_by INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_by INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periodes (id INT AUTO_INCREMENT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_by VARCHAR(255) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, permission VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_by VARCHAR(255) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, niveau_profil INT DEFAULT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_user (profil_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_85CBC6AB275ED078 (profil_id), INDEX IDX_85CBC6ABA76ED395 (user_id), PRIMARY KEY(profil_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suggestion (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, date DATE NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by INT NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_by INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_by INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_activite (id INT AUTO_INCREMENT NOT NULL, typt_activite_id_id INT NOT NULL, libelle LONGTEXT NOT NULL, annee INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by INT NOT NULL, update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', udapted_by INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_by INT DEFAULT NULL, UNIQUE INDEX UNIQ_758A72E9DFB4D8C5 (typt_activite_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_donnee (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_by VARCHAR(255) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_by VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_A6F00B6477153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, identifiant_agent VARCHAR(33) DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, mail VARCHAR(255) DEFAULT NULL, premiere_connexion TINYINT(1) NOT NULL, date_premiere_connexion DATETIME DEFAULT NULL, last_login DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649D139F311 (identifiant_agent), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profil_user ADD CONSTRAINT FK_85CBC6AB275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profil_user ADD CONSTRAINT FK_85CBC6ABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_activite ADD CONSTRAINT FK_758A72E9DFB4D8C5 FOREIGN KEY (typt_activite_id_id) REFERENCES type_activite (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D139F311 FOREIGN KEY (identifiant_agent) REFERENCES agent (identifiant_agent)');
        $this->addSql('ALTER TABLE reforme CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE created_by created_by VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profil_user DROP FOREIGN KEY FK_85CBC6AB275ED078');
        $this->addSql('ALTER TABLE profil_user DROP FOREIGN KEY FK_85CBC6ABA76ED395');
        $this->addSql('ALTER TABLE type_activite DROP FOREIGN KEY FK_758A72E9DFB4D8C5');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D139F311');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE bailleur');
        $this->addSql('DROP TABLE devises');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE mouchard');
        $this->addSql('DROP TABLE niveau_visibilite');
        $this->addSql('DROP TABLE periodes');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE profil_user');
        $this->addSql('DROP TABLE suggestion');
        $this->addSql('DROP TABLE type_activite');
        $this->addSql('DROP TABLE type_donnee');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE reforme CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE created_by created_by VARCHAR(255) DEFAULT NULL');
    }
}
