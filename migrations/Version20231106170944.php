<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231106170944 extends AbstractMigration
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
        $this->addSql('CREATE TABLE agent (identifiant_agent BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', structure_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', fonction_id INT NOT NULL, npi VARCHAR(10) DEFAULT NULL, ifu VARCHAR(13) DEFAULT NULL, matricule VARCHAR(6) DEFAULT NULL, nom VARCHAR(64) NOT NULL, prenom VARCHAR(128) NOT NULL, email VARCHAR(128) NOT NULL, telephone VARCHAR(128) NOT NULL, nomdejeunefille VARCHAR(64) DEFAULT NULL, sexe VARCHAR(8) NOT NULL, date_naissance DATE DEFAULT NULL, lieu_naissance VARCHAR(64) DEFAULT NULL, fullname VARCHAR(255) DEFAULT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_268B9C9D12B2DC9C (matricule), UNIQUE INDEX UNIQ_268B9C9D450FF010 (telephone), UNIQUE INDEX UNIQ_268B9C9D2534008B (structure_id), INDEX IDX_268B9C9D57889920 (fonction_id), PRIMARY KEY(identifiant_agent)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annee (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', libelle VARCHAR(255) NOT NULL, valeur VARCHAR(255) NOT NULL, actif TINYINT(1) NOT NULL, archiver VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bailleur (id INT AUTO_INCREMENT NOT NULL, libelle LONGTEXT NOT NULL, description LONGTEXT NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_document (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devise (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, taux DOUBLE PRECISION NOT NULL, libelle VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_43EDA4DF77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, categorie_document_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', structure_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', niveau_visibilite_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, url VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, INDEX IDX_D8698A761CC15E3E (categorie_document_id), INDEX IDX_D8698A762534008B (structure_id), INDEX IDX_D8698A76BD7A6A26 (niveau_visibilite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE executer (id INT AUTO_INCREMENT NOT NULL, annee_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', activite_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', periodicite_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', libelle VARCHAR(255) NOT NULL, taux_prevu DOUBLE PRECISION NOT NULL, taux_realiser DOUBLE PRECISION NOT NULL, observation LONGTEXT NOT NULL, date_execution DATE NOT NULL, archives VARCHAR(255) NOT NULL, INDEX IDX_D9D635E543EC5F0 (annee_id), INDEX IDX_D9D635E9B0F88B1 (activite_id), INDEX IDX_D9D635E2928752A (periodicite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_900D5BD77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mouchard (id INT AUTO_INCREMENT NOT NULL, entite VARCHAR(50) DEFAULT NULL, id_entite VARCHAR(255) NOT NULL, libelle_entite VARCHAR(255) DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, profil VARCHAR(50) DEFAULT NULL, observations LONGTEXT DEFAULT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_visibilite (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(100) NOT NULL, libelle VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periode (id INT AUTO_INCREMENT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periodicite (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', libelle VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, permission VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_E04992AAE04992AA (permission), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, niveau_profil INT DEFAULT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_user (profil_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_85CBC6AB275ED078 (profil_id), INDEX IDX_85CBC6ABA76ED395 (user_id), PRIMARY KEY(profil_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', structure_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', type_donnee_id INT NOT NULL, niveau_visibilite_id INT NOT NULL, type_graphe_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', libelle VARCHAR(255) NOT NULL, commentaire LONGTEXT NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, INDEX IDX_BE34A09C2534008B (structure_id), INDEX IDX_BE34A09C77D68DBD (type_donnee_id), INDEX IDX_BE34A09CBD7A6A26 (niveau_visibilite_id), INDEX IDX_BE34A09C9EE14231 (type_graphe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reforme (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_absolute VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', libelle VARCHAR(150) NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, telephone VARCHAR(128) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_6F0137EA450FF010 (telephone), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure_associe (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', structure_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', activite_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, INDEX IDX_F8F8DA7B2534008B (structure_id), INDEX IDX_F8F8DA7B9B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suggestion (id INT AUTO_INCREMENT NOT NULL, libelle LONGTEXT NOT NULL, date DATE NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_activite (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', typt_activite_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', periode_id INT NOT NULL, libelle LONGTEXT NOT NULL, annee INT NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_758A72E9B987207F (typt_activite_id), INDEX IDX_758A72E9F384C1CF (periode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_donnee (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_A6F00B6477153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_graphe (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', libelle VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_absolute VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, identifiant_agent BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, mail VARCHAR(255) DEFAULT NULL, premiere_connexion TINYINT(1) NOT NULL, date_premiere_connexion DATETIME DEFAULT NULL, last_login DATETIME DEFAULT NULL, code_activation VARCHAR(245) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649D139F311 (identifiant_agent), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
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
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D2534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D57889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A761CC15E3E FOREIGN KEY (categorie_document_id) REFERENCES categorie_document (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A762534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76BD7A6A26 FOREIGN KEY (niveau_visibilite_id) REFERENCES niveau_visibilite (id)');
        $this->addSql('ALTER TABLE executer ADD CONSTRAINT FK_D9D635E543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE executer ADD CONSTRAINT FK_D9D635E9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE executer ADD CONSTRAINT FK_D9D635E2928752A FOREIGN KEY (periodicite_id) REFERENCES periodicite (id)');
        $this->addSql('ALTER TABLE profil_user ADD CONSTRAINT FK_85CBC6AB275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profil_user ADD CONSTRAINT FK_85CBC6ABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C2534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C77D68DBD FOREIGN KEY (type_donnee_id) REFERENCES type_donnee (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CBD7A6A26 FOREIGN KEY (niveau_visibilite_id) REFERENCES niveau_visibilite (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C9EE14231 FOREIGN KEY (type_graphe_id) REFERENCES type_graphe (id)');
        $this->addSql('ALTER TABLE structure_associe ADD CONSTRAINT FK_F8F8DA7B2534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE structure_associe ADD CONSTRAINT FK_F8F8DA7B9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE type_activite ADD CONSTRAINT FK_758A72E9B987207F FOREIGN KEY (typt_activite_id) REFERENCES type_activite (id)');
        $this->addSql('ALTER TABLE type_activite ADD CONSTRAINT FK_758A72E9F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D139F311 FOREIGN KEY (identifiant_agent) REFERENCES agent (identifiant_agent)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
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
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D2534008B');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D57889920');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A761CC15E3E');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A762534008B');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76BD7A6A26');
        $this->addSql('ALTER TABLE executer DROP FOREIGN KEY FK_D9D635E543EC5F0');
        $this->addSql('ALTER TABLE executer DROP FOREIGN KEY FK_D9D635E9B0F88B1');
        $this->addSql('ALTER TABLE executer DROP FOREIGN KEY FK_D9D635E2928752A');
        $this->addSql('ALTER TABLE profil_user DROP FOREIGN KEY FK_85CBC6AB275ED078');
        $this->addSql('ALTER TABLE profil_user DROP FOREIGN KEY FK_85CBC6ABA76ED395');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C2534008B');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C77D68DBD');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09CBD7A6A26');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C9EE14231');
        $this->addSql('ALTER TABLE structure_associe DROP FOREIGN KEY FK_F8F8DA7B2534008B');
        $this->addSql('ALTER TABLE structure_associe DROP FOREIGN KEY FK_F8F8DA7B9B0F88B1');
        $this->addSql('ALTER TABLE type_activite DROP FOREIGN KEY FK_758A72E9B987207F');
        $this->addSql('ALTER TABLE type_activite DROP FOREIGN KEY FK_758A72E9F384C1CF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D139F311');
        $this->addSql('DROP TABLE action_bailleur');
        $this->addSql('DROP TABLE action_reforme');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE annee');
        $this->addSql('DROP TABLE bailleur');
        $this->addSql('DROP TABLE categorie_document');
        $this->addSql('DROP TABLE devise');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE executer');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE mouchard');
        $this->addSql('DROP TABLE niveau_visibilite');
        $this->addSql('DROP TABLE periode');
        $this->addSql('DROP TABLE periodicite');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE profil_user');
        $this->addSql('DROP TABLE rapport');
        $this->addSql('DROP TABLE reforme');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE structure_associe');
        $this->addSql('DROP TABLE suggestion');
        $this->addSql('DROP TABLE type_activite');
        $this->addSql('DROP TABLE type_donnee');
        $this->addSql('DROP TABLE type_graphe');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
