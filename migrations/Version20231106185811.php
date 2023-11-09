<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231106185811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE planifier (id INT AUTO_INCREMENT NOT NULL, annee_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', activite_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', libelle VARCHAR(255) NOT NULL, poids_action DOUBLE PRECISION NOT NULL, archiver TINYINT(1) NOT NULL, INDEX IDX_E539894A543EC5F0 (annee_id), INDEX IDX_E539894A9B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planifier ADD CONSTRAINT FK_E539894A543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE planifier ADD CONSTRAINT FK_E539894A9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planifier DROP FOREIGN KEY FK_E539894A543EC5F0');
        $this->addSql('ALTER TABLE planifier DROP FOREIGN KEY FK_E539894A9B0F88B1');
        $this->addSql('DROP TABLE planifier');
    }
}
