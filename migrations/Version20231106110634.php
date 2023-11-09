<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231106110634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
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
        $this->addSql('ALTER TABLE reforme CHANGE id id INT DEFAULT 0 NOT NULL, CHANGE description description LONGTEXT NOT NULL');
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
