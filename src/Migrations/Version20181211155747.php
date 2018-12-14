<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181211155747 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie_page (categorie_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_63233177BCF5E72D (categorie_id), INDEX IDX_63233177C4663E4 (page_id), PRIMARY KEY(categorie_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_page ADD CONSTRAINT FK_63233177BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_page ADD CONSTRAINT FK_63233177C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE page_categorie');
        $this->addSql('ALTER TABLE categorie CHANGE parent parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634727ACA70 FOREIGN KEY (parent_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_497DD634727ACA70 ON categorie (parent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page_categorie (page_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_729369FBC4663E4 (page_id), INDEX IDX_729369FBBCF5E72D (categorie_id), PRIMARY KEY(page_id, categorie_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_categorie ADD CONSTRAINT FK_729369FBBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_categorie ADD CONSTRAINT FK_729369FBC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE categorie_page');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634727ACA70');
        $this->addSql('DROP INDEX IDX_497DD634727ACA70 ON categorie');
        $this->addSql('ALTER TABLE categorie CHANGE parent_id parent INT DEFAULT NULL');
    }
}
