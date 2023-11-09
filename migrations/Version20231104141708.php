<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231104141708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_at, DROP updated_by, DROP deleted_at, DROP deleted_by');
        $this->addSql('ALTER TABLE type_graphe ADD created DATETIME DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD last_updated_auteur VARCHAR(255) DEFAULT NULL, ADD supprimer TINYINT(1) DEFAULT NULL, ADD supprimer_date DATETIME DEFAULT NULL, ADD supprimer_auteur VARCHAR(255) DEFAULT NULL, DROP created_at, DROP created_by, DROP updated_at, DROP updated_by, DROP deleted_at, DROP deleted_by');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by INT DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_by INT DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by INT DEFAULT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur');
        $this->addSql('ALTER TABLE type_graphe ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by INT DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_by INT DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_by INT DEFAULT NULL, DROP created, DROP auteur, DROP last_updated, DROP last_updated_auteur, DROP supprimer, DROP supprimer_date, DROP supprimer_auteur');
    }
}
