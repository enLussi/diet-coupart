<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230424185706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opinion CHANGE published_date published_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137E1E13ACE');
        $this->addSql('DROP INDEX IDX_DA88B137E1E13ACE ON recipe');
        $this->addSql('ALTER TABLE recipe DROP diet_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opinion CHANGE published_date published_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE recipe ADD diet_id INT NOT NULL');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137E1E13ACE FOREIGN KEY (diet_id) REFERENCES diet (id)');
        $this->addSql('CREATE INDEX IDX_DA88B137E1E13ACE ON recipe (diet_id)');
    }
}
