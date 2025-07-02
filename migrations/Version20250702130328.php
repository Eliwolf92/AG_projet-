<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250702130328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE demandes (id INT AUTO_INCREMENT NOT NULL, demandeurs_id INT DEFAULT NULL, artiste_id INT DEFAULT NULL, message LONGTEXT NOT NULL, INDEX IDX_BD940CBBF553F29B (demandeurs_id), INDEX IDX_BD940CBB21D25844 (artiste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_F413DD03A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demandes ADD CONSTRAINT FK_BD940CBBF553F29B FOREIGN KEY (demandeurs_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demandes ADD CONSTRAINT FK_BD940CBB21D25844 FOREIGN KEY (artiste_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE service_request ADD CONSTRAINT FK_F413DD03A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE art DROP updated_at
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE demandes DROP FOREIGN KEY FK_BD940CBBF553F29B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demandes DROP FOREIGN KEY FK_BD940CBB21D25844
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE service_request DROP FOREIGN KEY FK_F413DD03A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE demandes
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE service_request
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE art ADD updated_at DATETIME DEFAULT NULL
        SQL);
    }
}
