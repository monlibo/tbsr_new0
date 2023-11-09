<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231105125350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action_bailleur (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', bailleur_id INT NOT NULL, activite_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, INDEX IDX_AD6C579557B5D0A2 (bailleur_id), INDEX IDX_AD6C57959B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_reforme (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', reforme_id INT NOT NULL, activite_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, INDEX IDX_ABC951CFDE08682D (reforme_id), INDEX IDX_ABC951CF9B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activite (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', activite_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', type_activite_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', structure_id INT DEFAULT NULL, annee_debut_id INT DEFAULT NULL, annee_fin_id INT DEFAULT NULL, annee_id INT DEFAULT NULL, devise_id INT DEFAULT NULL, num_activite VARCHAR(50) NOT NULL, libelle_activite LONGTEXT NOT NULL, objectif_principal LONGTEXT DEFAULT NULL, objectif_specifique LONGTEXT DEFAULT NULL, libelle_int_comp LONGTEXT DEFAULT NULL, libelle_indicateur_individuel LONGTEXT DEFAULT NULL, cout_activite DOUBLE PRECISION DEFAULT NULL, cout_activite_fcfa DOUBLE PRECISION DEFAULT NULL, resultat_attendu LONGTEXT DEFAULT NULL, date_delai_execution DATE DEFAULT NULL, date_execution DATE DEFAULT NULL, poids DOUBLE PRECISION DEFAULT NULL, archiver TINYINT(1) DEFAULT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B87555159B0F88B1 (activite_id), INDEX IDX_B8755515D0165F20 (type_activite_id), INDEX IDX_B87555152534008B (structure_id), INDEX IDX_B8755515CAC5228D (annee_debut_id), INDEX IDX_B875551556BAF9F6 (annee_fin_id), INDEX IDX_B8755515543EC5F0 (annee_id), INDEX IDX_B8755515F4445056 (devise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure_associe (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', structure_id INT NOT NULL, activite_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, INDEX IDX_F8F8DA7B2534008B (structure_id), INDEX IDX_F8F8DA7B9B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
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
        $this->addSql('ALTER TABLE agent DROP INDEX FK_268B9C9D2534008B, ADD UNIQUE INDEX UNIQ_268B9C9D2534008B (structure_id)');
        $this->addSql('ALTER TABLE type_activite DROP INDEX IDX_854D455FR, ADD UNIQUE INDEX UNIQ_758A72E9B987207F (typt_activite_id)');
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
        $this->addSql('DROP TABLE structure_associe');
        $this->addSql('ALTER TABLE agent DROP INDEX UNIQ_268B9C9D2534008B, ADD INDEX FK_268B9C9D2534008B (structure_id)');
        $this->addSql('ALTER TABLE type_activite DROP INDEX UNIQ_758A72E9B987207F, ADD INDEX IDX_854D455FR (typt_activite_id)');
    }
}
