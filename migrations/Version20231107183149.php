<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231107183149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role_user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', iduser BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', idrole BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action_bailleur DROP FOREIGN KEY FK_AD6C579557B5D0A2');
        $this->addSql('ALTER TABLE action_bailleur DROP FOREIGN KEY FK_AD6C57959B0F88B1');
        $this->addSql('ALTER TABLE action_reforme DROP FOREIGN KEY FK_ABC951CF9B0F88B1');
        $this->addSql('ALTER TABLE action_reforme DROP FOREIGN KEY FK_ABC951CFDE08682D');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B87555152534008B');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515543EC5F0');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B875551556BAF9F6');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B87555159B0F88B1');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515CAC5228D');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515D0165F20');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515F4445056');
        $this->addSql('ALTER TABLE structure_associe DROP FOREIGN KEY FK_F8F8DA7B2534008B');
        $this->addSql('ALTER TABLE structure_associe DROP FOREIGN KEY FK_F8F8DA7B9B0F88B1');
        $this->addSql('DROP TABLE action_bailleur');
        $this->addSql('DROP TABLE action_reforme');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE structure_associe');
        $this->addSql('ALTER TABLE role DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE libelle libelle JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action_bailleur (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', bailleur_id INT NOT NULL, activite_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME DEFAULT NULL, auteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_AD6C579557B5D0A2 (bailleur_id), INDEX IDX_AD6C57959B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE action_reforme (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', reforme_id INT NOT NULL, activite_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME DEFAULT NULL, auteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_ABC951CF9B0F88B1 (activite_id), INDEX IDX_ABC951CFDE08682D (reforme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE activite (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', activite_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', type_activite_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', structure_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', annee_debut_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', annee_fin_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', annee_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', devise_id INT DEFAULT NULL, num_activite VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, libelle_activite LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, objectif_principal LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, objectif_specifique LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, libelle_int_comp LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, libelle_indicateur_individuel LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, cout_activite DOUBLE PRECISION DEFAULT NULL, cout_activite_fcfa DOUBLE PRECISION DEFAULT NULL, resultat_attendu LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date_delai_execution DATE DEFAULT NULL, date_execution DATE DEFAULT NULL, poids DOUBLE PRECISION DEFAULT NULL, archiver TINYINT(1) DEFAULT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_B87555152534008B (structure_id), INDEX IDX_B8755515543EC5F0 (annee_id), INDEX IDX_B875551556BAF9F6 (annee_fin_id), INDEX IDX_B8755515CAC5228D (annee_debut_id), INDEX IDX_B8755515D0165F20 (type_activite_id), INDEX IDX_B8755515F4445056 (devise_id), UNIQUE INDEX UNIQ_B87555159B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE structure_associe (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', structure_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', activite_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME DEFAULT NULL, auteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_F8F8DA7B2534008B (structure_id), INDEX IDX_F8F8DA7B9B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE action_bailleur ADD CONSTRAINT FK_AD6C579557B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE action_bailleur ADD CONSTRAINT FK_AD6C57959B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE action_reforme ADD CONSTRAINT FK_ABC951CF9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE action_reforme ADD CONSTRAINT FK_ABC951CFDE08682D FOREIGN KEY (reforme_id) REFERENCES reforme (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555152534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B875551556BAF9F6 FOREIGN KEY (annee_fin_id) REFERENCES annee (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555159B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515CAC5228D FOREIGN KEY (annee_debut_id) REFERENCES annee (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515D0165F20 FOREIGN KEY (type_activite_id) REFERENCES type_activite (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515F4445056 FOREIGN KEY (devise_id) REFERENCES devise (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE structure_associe ADD CONSTRAINT FK_F8F8DA7B2534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE structure_associe ADD CONSTRAINT FK_F8F8DA7B9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE role_user');
        $this->addSql('ALTER TABLE role ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE libelle libelle VARCHAR(150) NOT NULL');
    }
}
