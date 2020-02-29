<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200229123211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE artists ADD user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE artists ADD CONSTRAINT FK_68D3801EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_68D3801EA76ED395 ON artists (user_id)');

        $this->addSql('ALTER TABLE fans ADD user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE fans ADD CONSTRAINT FK_446EB07BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_446EB07BA76ED395 ON fans (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE artists DROP FOREIGN KEY FK_68D3801EA76ED395');
        $this->addSql('DROP INDEX UNIQ_68D3801EA76ED395 ON artists');
        $this->addSql('ALTER TABLE artists DROP user_id');

        $this->addSql('ALTER TABLE fans DROP FOREIGN KEY FK_446EB07BA76ED395');
        $this->addSql('DROP INDEX UNIQ_446EB07BA76ED395 ON fans');
        $this->addSql('ALTER TABLE fans DROP user_id');
    }
}
