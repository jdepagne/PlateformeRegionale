<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190114160442 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE date_modification date_modification DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE module CHANGE contenu_court contenu_court VARCHAR(255) DEFAULT NULL, CHANGE date_modification date_modification DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE page CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE description_page description_page VARCHAR(255) DEFAULT NULL, CHANGE date_modification_page date_modification_page DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE page_module CHANGE page_id page_id INT DEFAULT NULL, CHANGE module_id module_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE date_modification date_modification DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE module CHANGE contenu_court contenu_court VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE date_modification date_modification DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE page CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE description_page description_page VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE date_modification_page date_modification_page DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE page_module CHANGE page_id page_id INT DEFAULT NULL, CHANGE module_id module_id INT DEFAULT NULL');
    }
}
