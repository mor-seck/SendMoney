<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190727182150 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, libelle_du_type_de_role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personne ADD user_id INT DEFAULT NULL, CHANGE type_id type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EFA76ED395 ON personne (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFC54C8C93');
        $this->addSql('DROP TABLE type');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFA76ED395');
        $this->addSql('DROP INDEX IDX_FCEC9EFA76ED395 ON personne');
        $this->addSql('ALTER TABLE personne DROP user_id, CHANGE type_id type_id INT NOT NULL');
    }
}
