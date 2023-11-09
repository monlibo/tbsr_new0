<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231105091628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rapport (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', structure_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', type_donnee_id INT NOT NULL, niveau_visibilite_id INT NOT NULL, type_graphe_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', libelle VARCHAR(255) NOT NULL, commentaire LONGTEXT NOT NULL, created DATETIME DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, last_updated DATETIME DEFAULT NULL, last_updated_auteur VARCHAR(255) DEFAULT NULL, supprimer TINYINT(1) DEFAULT NULL, supprimer_date DATETIME DEFAULT NULL, supprimer_auteur VARCHAR(255) DEFAULT NULL, INDEX IDX_BE34A09C2534008B (structure_id), INDEX IDX_BE34A09C77D68DBD (type_donnee_id), INDEX IDX_BE34A09CBD7A6A26 (niveau_visibilite_id), INDEX IDX_BE34A09C9EE14231 (type_graphe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C2534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C77D68DBD FOREIGN KEY (type_donnee_id) REFERENCES type_donnee (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CBD7A6A26 FOREIGN KEY (niveau_visibilite_id) REFERENCES niveau_visibilite (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C9EE14231 FOREIGN KEY (type_graphe_id) REFERENCES type_graphe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C2534008B');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C77D68DBD');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09CBD7A6A26');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C9EE14231');
        $this->addSql('DROP TABLE rapport');
    }
}
