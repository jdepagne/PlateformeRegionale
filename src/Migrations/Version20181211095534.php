<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181211095534 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page_module_categorie (page_module_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_721B8120942C0A5E (page_module_id), INDEX IDX_721B8120BCF5E72D (categorie_id), PRIMARY KEY(page_module_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_module_categorie ADD CONSTRAINT FK_721B8120942C0A5E FOREIGN KEY (page_module_id) REFERENCES page_module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_module_categorie ADD CONSTRAINT FK_721B8120BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE page_module_categorie');
    }
}
