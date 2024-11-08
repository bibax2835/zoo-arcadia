<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107161510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal CHANGE slug slug VARCHAR(128) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AAB231F989D9B62 ON animal (slug)');
        $this->addSql('ALTER TABLE comment ADD pseudonym VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_6AAB231F989D9B62 ON animal');
        $this->addSql('ALTER TABLE animal CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE comment DROP pseudonym');
    }
}
