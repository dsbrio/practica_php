<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180218092953 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE move (id INT AUTO_INCREMENT NOT NULL, master_mind_game_id INT DEFAULT NULL, date DATETIME NOT NULL, color_list LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', evaluation VARCHAR(255) NOT NULL, INDEX IDX_EF3E3778402D7F51 (master_mind_game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE move ADD CONSTRAINT FK_EF3E3778402D7F51 FOREIGN KEY (master_mind_game_id) REFERENCES master_mind_game (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE move');
    }
}
