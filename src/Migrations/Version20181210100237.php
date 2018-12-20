<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181210100237 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, titre_page VARCHAR(255) NOT NULL, description_page VARCHAR(255) DEFAULT NULL, etat_publication_page TINYINT(1) NOT NULL, date_insertion_page DATETIME NOT NULL, date_modification_page DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_categorie (page_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_729369FBC4663E4 (page_id), INDEX IDX_729369FBBCF5E72D (categorie_id), PRIMARY KEY(page_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_categorie ADD CONSTRAINT FK_729369FBC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_categorie ADD CONSTRAINT FK_729369FBBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_categorie DROP FOREIGN KEY FK_729369FBC4663E4');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_categorie');
    }
}
