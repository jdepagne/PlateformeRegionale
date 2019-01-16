<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190115110702 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date_modification DATETIME DEFAULT NULL, INDEX IDX_497DD634727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, etat_publication TINYINT(1) NOT NULL, contenu LONGTEXT DEFAULT NULL, contenu_court VARCHAR(255) DEFAULT NULL, date_insertion DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_categorie (module_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_131CC9FCAFC2B591 (module_id), INDEX IDX_131CC9FCBCF5E72D (categorie_id), PRIMARY KEY(module_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, titre_page VARCHAR(255) NOT NULL, description_page VARCHAR(255) DEFAULT NULL, etat_publication_page TINYINT(1) NOT NULL, date_insertion_page DATETIME NOT NULL, date_modification_page DATETIME DEFAULT NULL, INDEX IDX_140AB620727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_page (page_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_63233177C4663E4 (page_id), INDEX IDX_63233177BCF5E72D (categorie_id), PRIMARY KEY(page_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_module (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, module_id INT DEFAULT NULL, INDEX IDX_63F2D036C4663E4 (page_id), INDEX IDX_63F2D036AFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634727ACA70 FOREIGN KEY (parent_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE module_categorie ADD CONSTRAINT FK_131CC9FCAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_categorie ADD CONSTRAINT FK_131CC9FCBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620727ACA70 FOREIGN KEY (parent_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE categorie_page ADD CONSTRAINT FK_63233177C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_page ADD CONSTRAINT FK_63233177BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_module ADD CONSTRAINT FK_63F2D036C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page_module ADD CONSTRAINT FK_63F2D036AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634727ACA70');
        $this->addSql('ALTER TABLE module_categorie DROP FOREIGN KEY FK_131CC9FCBCF5E72D');
        $this->addSql('ALTER TABLE categorie_page DROP FOREIGN KEY FK_63233177BCF5E72D');
        $this->addSql('ALTER TABLE module_categorie DROP FOREIGN KEY FK_131CC9FCAFC2B591');
        $this->addSql('ALTER TABLE page_module DROP FOREIGN KEY FK_63F2D036AFC2B591');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620727ACA70');
        $this->addSql('ALTER TABLE categorie_page DROP FOREIGN KEY FK_63233177C4663E4');
        $this->addSql('ALTER TABLE page_module DROP FOREIGN KEY FK_63F2D036C4663E4');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE module_categorie');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE categorie_page');
        $this->addSql('DROP TABLE page_module');
    }
}
