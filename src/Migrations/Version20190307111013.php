<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190307111013 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE phone ADD image_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DD68011AFE FOREIGN KEY (image_id_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_444F97DD68011AFE ON phone (image_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_444F97DD68011AFE');
        $this->addSql('DROP INDEX UNIQ_444F97DD68011AFE ON phone');
        $this->addSql('ALTER TABLE phone DROP image_id_id');
    }
}
