<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231106112914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action_bailleur (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', bailleur_id INT NOT NULL, activite_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, INDEX IDX_AD6C579557B5D0A2 (bailleur_id), INDEX IDX_AD6C57959B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_reforme (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', reforme_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', activite_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, INDEX IDX_ABC951CFDE08682D (reforme_id), INDEX IDX_ABC951CF9B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activite (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', activite_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', type_activite_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', structure_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', annee_debut_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', annee_fin_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', annee_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', devise_id INT DEFAULT NULL, num_activite VARCHAR(50) NOT NULL, libelle_activite LONGTEXT NOT NULL, objectif_principal LONGTEXT DEFAULT NULL, objectif_specifique LONGTEXT DEFAULT NULL, libelle_int_comp LONGTEXT DEFAULT NULL, libelle_indicateur_individuel LONGTEXT DEFAULT NULL, cout_activite DOUBLE PRECISION DEFAULT NULL, cout_activite_fcfa DOUBLE PRECISION DEFAULT NULL, resultat_attendu LONGTEXT DEFAULT NULL, date_delai_execution DATE DEFAULT NULL, date_execution DATE DEFAULT NULL, poids DOUBLE PRECISION DEFAULT NULL, archiver TINYINT(1) DEFAULT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B87555159B0F88B1 (activite_id), INDEX IDX_B8755515D0165F20 (type_activite_id), INDEX IDX_B87555152534008B (structure_id), INDEX IDX_B8755515CAC5228D (annee_debut_id), INDEX IDX_B875551556BAF9F6 (annee_fin_id), INDEX IDX_B8755515543EC5F0 (annee_id), INDEX IDX_B8755515F4445056 (devise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', libelle VARCHAR(150) NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure_associe (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', structure_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', activite_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, INDEX IDX_F8F8DA7B2534008B (structure_id), INDEX IDX_F8F8DA7B9B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action_bailleur ADD CONSTRAINT FK_AD6C579557B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id)');
        $this->addSql('ALTER TABLE action_bailleur ADD CONSTRAINT FK_AD6C57959B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE action_reforme ADD CONSTRAINT FK_ABC951CFDE08682D FOREIGN KEY (reforme_id) REFERENCES reforme (id)');
        $this->addSql('ALTER TABLE action_reforme ADD CONSTRAINT FK_ABC951CF9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555159B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515D0165F20 FOREIGN KEY (type_activite_id) REFERENCES type_activite (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555152534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515CAC5228D FOREIGN KEY (annee_debut_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B875551556BAF9F6 FOREIGN KEY (annee_fin_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515F4445056 FOREIGN KEY (devise_id) REFERENCES devise (id)');
        $this->addSql('ALTER TABLE structure_associe ADD CONSTRAINT FK_F8F8DA7B2534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE structure_associe ADD CONSTRAINT FK_F8F8DA7B9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('DROP TABLE devises');
        $this->addSql('DROP TABLE periodes');
        $this->addSql('ALTER TABLE agent ADD structure_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', ADD fonction_id INT NOT NULL, ADD email VARCHAR(128) NOT NULL, ADD telephone VARCHAR(128) NOT NULL, CHANGE identifiant_agent identifiant_agent BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D2534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D57889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_268B9C9D12B2DC9C ON agent (matricule)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_268B9C9D450FF010 ON agent (telephone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_268B9C9D2534008B ON agent (structure_id)');
        $this->addSql('CREATE INDEX IDX_268B9C9D57889920 ON agent (fonction_id)');
        $this->addSql('ALTER TABLE devise ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_at, DROP updated_by, DROP deleted_at, DROP deleted_by');
        $this->addSql('ALTER TABLE devise RENAME INDEX uniq_d21edea77153098 TO UNIQ_43EDA4DF77153098');
        $this->addSql('ALTER TABLE fonction ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_by, DROP updated_at, DROP deleted_at, DROP deleted_by');
        $this->addSql('ALTER TABLE niveau_visibilite ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_at, DROP updated_by, DROP deleted_at, DROP deleted_by');
        $this->addSql('ALTER TABLE permission ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_at, DROP updated_by, DROP deleted_at, DROP deleted_by');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E04992AAE04992AA ON permission (permission)');
        $this->addSql('ALTER TABLE reforme CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE structure CHANGE telephone telephone VARCHAR(128) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6F0137EA450FF010 ON structure (telephone)');
        $this->addSql('ALTER TABLE suggestion ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_at, DROP updated_by, DROP deleted_at, DROP deleted_by, CHANGE libelle libelle LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE type_activite DROP FOREIGN KEY FK_758A72E9DFB4D8C5');
        $this->addSql('DROP INDEX UNIQ_758A72E9DFB4D8C5 ON type_activite');
        $this->addSql('ALTER TABLE type_activite ADD typt_activite_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', ADD periode_id INT NOT NULL, ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP typt_activite_id_id, DROP created_at, DROP created_by, DROP update_at, DROP udapted_by, DROP deleted_at, DROP deleted_by, CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE type_activite ADD CONSTRAINT FK_758A72E9B987207F FOREIGN KEY (typt_activite_id) REFERENCES type_activite (id)');
        $this->addSql('ALTER TABLE type_activite ADD CONSTRAINT FK_758A72E9F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_758A72E9B987207F ON type_activite (typt_activite_id)');
        $this->addSql('CREATE INDEX IDX_758A72E9F384C1CF ON type_activite (periode_id)');
        $this->addSql('ALTER TABLE type_donnee ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_at, DROP updated_by, DROP deleted_at, DROP deleted_by');
        $this->addSql('ALTER TABLE user ADD code_activation VARCHAR(245) NOT NULL, CHANGE identifiant_agent identifiant_agent BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE devises (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, taux DOUBLE PRECISION NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_by VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_by VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_D21EDEA77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE periodes (id INT AUTO_INCREMENT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_by VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_by VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE action_bailleur DROP FOREIGN KEY FK_AD6C579557B5D0A2');
        $this->addSql('ALTER TABLE action_bailleur DROP FOREIGN KEY FK_AD6C57959B0F88B1');
        $this->addSql('ALTER TABLE action_reforme DROP FOREIGN KEY FK_ABC951CFDE08682D');
        $this->addSql('ALTER TABLE action_reforme DROP FOREIGN KEY FK_ABC951CF9B0F88B1');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B87555159B0F88B1');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515D0165F20');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B87555152534008B');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515CAC5228D');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B875551556BAF9F6');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515543EC5F0');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515F4445056');
        $this->addSql('ALTER TABLE structure_associe DROP FOREIGN KEY FK_F8F8DA7B2534008B');
        $this->addSql('ALTER TABLE structure_associe DROP FOREIGN KEY FK_F8F8DA7B9B0F88B1');
        $this->addSql('DROP TABLE action_bailleur');
        $this->addSql('DROP TABLE action_reforme');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE structure_associe');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D2534008B');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D57889920');
        $this->addSql('DROP INDEX UNIQ_268B9C9D12B2DC9C ON agent');
        $this->addSql('DROP INDEX UNIQ_268B9C9D450FF010 ON agent');
        $this->addSql('DROP INDEX UNIQ_268B9C9D2534008B ON agent');
        $this->addSql('DROP INDEX IDX_268B9C9D57889920 ON agent');
        $this->addSql('ALTER TABLE agent DROP structure_id, DROP fonction_id, DROP email, DROP telephone, CHANGE identifiant_agent identifiant_agent VARCHAR(33) NOT NULL');
        $this->addSql('ALTER TABLE devise ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by VARCHAR(255) NOT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_by VARCHAR(255) DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by VARCHAR(255) DEFAULT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur');
        $this->addSql('ALTER TABLE devise RENAME INDEX uniq_43eda4df77153098 TO UNIQ_D21EDEA77153098');
        $this->addSql('ALTER TABLE fonction ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by VARCHAR(255) NOT NULL, ADD updated_by VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by VARCHAR(255) DEFAULT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur');
        $this->addSql('ALTER TABLE niveau_visibilite ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by INT NOT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_by INT DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by INT DEFAULT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur');
        $this->addSql('DROP INDEX UNIQ_E04992AAE04992AA ON permission');
        $this->addSql('ALTER TABLE permission ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by VARCHAR(255) NOT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_by VARCHAR(255) DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by VARCHAR(255) DEFAULT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur');
        $this->addSql('ALTER TABLE reforme CHANGE id id BINARY(50) DEFAULT \'0x\' NOT NULL, CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_6F0137EA450FF010 ON structure');
        $this->addSql('ALTER TABLE structure CHANGE telephone telephone INT NOT NULL');
        $this->addSql('ALTER TABLE suggestion ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by INT NOT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_by INT DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by INT DEFAULT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur, CHANGE libelle libelle VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE type_activite DROP FOREIGN KEY FK_758A72E9B987207F');
        $this->addSql('ALTER TABLE type_activite DROP FOREIGN KEY FK_758A72E9F384C1CF');
        $this->addSql('DROP INDEX UNIQ_758A72E9B987207F ON type_activite');
        $this->addSql('DROP INDEX IDX_758A72E9F384C1CF ON type_activite');
        $this->addSql('ALTER TABLE type_activite ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by INT NOT NULL, ADD update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD udapted_by INT DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by INT DEFAULT NULL, DROP typt_activite_id, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE periode_id typt_activite_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE type_activite ADD CONSTRAINT FK_758A72E9DFB4D8C5 FOREIGN KEY (typt_activite_id_id) REFERENCES type_activite (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_758A72E9DFB4D8C5 ON type_activite (typt_activite_id_id)');
        $this->addSql('ALTER TABLE type_donnee ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by VARCHAR(255) NOT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_by VARCHAR(255) DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by VARCHAR(255) DEFAULT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur');
        $this->addSql('ALTER TABLE user DROP code_activation, CHANGE identifiant_agent identifiant_agent VARCHAR(33) DEFAULT NULL');
    }
}
