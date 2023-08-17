<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230810181020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auction (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', current_price DOUBLE PRECISION NOT NULL, winner VARCHAR(255) DEFAULT NULL, auction_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, start_price DOUBLE PRECISION NOT NULL, seller VARCHAR(255) NOT NULL, ended_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_DEE4F5932B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auction_user (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', auction_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', bid_amount DOUBLE PRECISION NOT NULL, INDEX IDX_46F88DEA57B8F0DE (auction_id), PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE auction_user ADD CONSTRAINT FK_46F88DEA57B8F0DE FOREIGN KEY (auction_id) REFERENCES auction (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auction_user DROP FOREIGN KEY FK_46F88DEA57B8F0DE');
        $this->addSql('DROP TABLE auction');
        $this->addSql('DROP TABLE auction_user');
    }
}
