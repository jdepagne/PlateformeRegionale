<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181206105049 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, etat_publication TINYINT(1) NOT NULL, contenu LONGTEXT DEFAULT NULL, contenu_court VARCHAR(255) DEFAULT NULL, date_insertion DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_categorie (module_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_131CC9FCAFC2B591 (module_id), INDEX IDX_131CC9FCBCF5E72D (categorie_id), PRIMARY KEY(module_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date_modification DATETIME DEFAULT NULL, parent INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE module_categorie ADD CONSTRAINT FK_131CC9FCAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_categorie ADD CONSTRAINT FK_131CC9FCBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE module_categorie DROP FOREIGN KEY FK_131CC9FCAFC2B591');
        $this->addSql('ALTER TABLE module_categorie DROP FOREIGN KEY FK_131CC9FCBCF5E72D');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE module_categorie');
        $this->addSql('DROP TABLE categorie');
    }
}
