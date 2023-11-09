<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231106085732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555152534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515CAC5228D FOREIGN KEY (annee_debut_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B875551556BAF9F6 FOREIGN KEY (annee_fin_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515F4445056 FOREIGN KEY (devise_id) REFERENCES devise (id)');
        $this->addSql('ALTER TABLE agent CHANGE structure_id structure_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE annee ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_at, DROP updated_by, DROP deleted_at, DROP deleted_by, CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE categorie_document ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_at, DROP updated_by, DROP deleted_at, DROP deleted_by, CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE periodicite ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_at, DROP updated_by, DROP deleted_at, DROP deleted_by, CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C2534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C77D68DBD FOREIGN KEY (type_donnee_id) REFERENCES type_donnee (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CBD7A6A26 FOREIGN KEY (niveau_visibilite_id) REFERENCES niveau_visibilite (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C9EE14231 FOREIGN KEY (type_graphe_id) REFERENCES type_graphe (id)');
        $this->addSql('ALTER TABLE reforme ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_at, DROP updated_by, DROP deleted_at, DROP deleted_by');
        $this->addSql('ALTER TABLE structure ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_at, DROP updated_by, DROP deleted_at, DROP deleted_by, CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE structure_associe ADD CONSTRAINT FK_F8F8DA7B2534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE structure_associe ADD CONSTRAINT FK_F8F8DA7B9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE type_graphe ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_at, DROP updated_by, DROP deleted_at, DROP deleted_by, CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B87555152534008B');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515CAC5228D');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B875551556BAF9F6');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515543EC5F0');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515F4445056');
        $this->addSql('ALTER TABLE agent CHANGE structure_id structure_id INT NOT NULL');
        $this->addSql('ALTER TABLE annee ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by INT DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_by INT DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by INT DEFAULT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE categorie_document ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by INT NOT NULL, ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_by INT NOT NULL, ADD deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by INT NOT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE periodicite ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_by VARCHAR(255) DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by VARCHAR(255) DEFAULT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C2534008B');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C77D68DBD');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09CBD7A6A26');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C9EE14231');
        $this->addSql('ALTER TABLE reforme ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by VARCHAR(255) NOT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_by VARCHAR(255) DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by VARCHAR(255) DEFAULT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur');
        $this->addSql('ALTER TABLE structure ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by INT DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_by INT DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by INT DEFAULT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE structure_associe DROP FOREIGN KEY FK_F8F8DA7B2534008B');
        $this->addSql('ALTER TABLE structure_associe DROP FOREIGN KEY FK_F8F8DA7B9B0F88B1');
        $this->addSql('ALTER TABLE type_graphe ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by INT DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_by INT DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by INT DEFAULT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur, CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
