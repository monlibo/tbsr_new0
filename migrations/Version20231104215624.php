<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231104215624 extends AbstractMigration
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
        $this->addSql('ALTER TABLE agent ADD structure_id INT NOT NULL, ADD fonction_id INT NOT NULL, CHANGE identifiant_agent identifiant_agent BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D2534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D57889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_268B9C9D12B2DC9C ON agent (matricule)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_268B9C9D450FF010 ON agent (telephone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_268B9C9D2534008B ON agent (structure_id)');
        $this->addSql('CREATE INDEX IDX_268B9C9D57889920 ON agent (fonction_id)');
        $this->addSql('ALTER TABLE user CHANGE identifiant_agent identifiant_agent BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
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
        $this->addSql('ALTER TABLE agent DROP structure_id, DROP fonction_id, CHANGE identifiant_agent identifiant_agent VARCHAR(33) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE identifiant_agent identifiant_agent VARCHAR(33) DEFAULT NULL');
    }
}
