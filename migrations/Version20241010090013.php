<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241010090013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_habitat (animal_id INT NOT NULL, habitat_id INT NOT NULL, INDEX IDX_B4E8DDD28E962C16 (animal_id), INDEX IDX_B4E8DDD2AFFE2D26 (habitat_id), PRIMARY KEY(animal_id, habitat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinary_report (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, date DATETIME NOT NULL, state LONGTEXT NOT NULL, food VARCHAR(255) NOT NULL, food_quantity DOUBLE PRECISION NOT NULL, INDEX IDX_53C7E56B8E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal_habitat ADD CONSTRAINT FK_B4E8DDD28E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animal_habitat ADD CONSTRAINT FK_B4E8DDD2AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE veterinary_report ADD CONSTRAINT FK_53C7E56B8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_habitat DROP FOREIGN KEY FK_B4E8DDD28E962C16');
        $this->addSql('ALTER TABLE animal_habitat DROP FOREIGN KEY FK_B4E8DDD2AFFE2D26');
        $this->addSql('ALTER TABLE veterinary_report DROP FOREIGN KEY FK_53C7E56B8E962C16');
        $this->addSql('DROP TABLE animal_habitat');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE veterinary_report');
    }
}
