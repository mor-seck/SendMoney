<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190730202814 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCAF1E371E');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCA21BD112');
        $this->addSql('ALTER TABLE partenaire DROP FOREIGN KEY FK_32FFA373A21BD112');
        $this->addSql('DROP TABLE compte_bancaire');
        $this->addSql('DROP TABLE depot');
        $this->addSql('DROP TABLE personne');
        $this->addSql('ALTER TABLE user ADD prenom VARCHAR(255) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD telephone VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX IDX_32FFA373A21BD112 ON partenaire');
        $this->addSql('ALTER TABLE partenaire ADD user_id INT DEFAULT NULL, ADD raisonsociale VARCHAR(255) NOT NULL, ADD statut VARCHAR(255) NOT NULL, DROP personne_id, DROP raison_sociale, DROP status');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA373A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_32FFA373A76ED395 ON partenaire (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE compte_bancaire (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT NOT NULL, numero_compte VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_50BC21DE98DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, personne_id INT DEFAULT NULL, compte_bancaire_id INT DEFAULT NULL, montant BIGINT NOT NULL, date_depot DATE NOT NULL, INDEX IDX_47948BBCA21BD112 (personne_id), INDEX IDX_47948BBCAF1E371E (compte_bancaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, adresse VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, telephone VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, type_id INT DEFAULT NULL, INDEX IDX_FCEC9EFC54C8C93 (type_id), INDEX IDX_FCEC9EFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE compte_bancaire ADD CONSTRAINT FK_50BC21DE98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCAF1E371E FOREIGN KEY (compte_bancaire_id) REFERENCES compte_bancaire (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE partenaire DROP FOREIGN KEY FK_32FFA373A76ED395');
        $this->addSql('DROP INDEX IDX_32FFA373A76ED395 ON partenaire');
        $this->addSql('ALTER TABLE partenaire ADD personne_id INT NOT NULL, ADD raison_sociale VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD status VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP user_id, DROP raisonsociale, DROP statut');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA373A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
        $this->addSql('CREATE INDEX IDX_32FFA373A21BD112 ON partenaire (personne_id)');
        $this->addSql('ALTER TABLE user DROP prenom, DROP nom, DROP adresse, DROP telephone, DROP email');
    }
}
