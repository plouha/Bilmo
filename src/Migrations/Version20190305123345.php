<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190305123345 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F8C1EEB4D');
        $this->addSql('DROP INDEX UNIQ_C53D045F8C1EEB4D ON image');
        $this->addSql('ALTER TABLE image CHANGE phone_id_id phone_id INT NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F3B7323CB FOREIGN KEY (phone_id) REFERENCES phone (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045F3B7323CB ON image (phone_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F3B7323CB');
        $this->addSql('DROP INDEX UNIQ_C53D045F3B7323CB ON image');
        $this->addSql('ALTER TABLE image CHANGE phone_id phone_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F8C1EEB4D FOREIGN KEY (phone_id_id) REFERENCES phone (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045F8C1EEB4D ON image (phone_id_id)');
    }
}
