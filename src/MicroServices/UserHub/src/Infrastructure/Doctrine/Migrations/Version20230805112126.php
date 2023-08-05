<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230805112126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bid (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', pierced TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_4AF2B3F3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', transaction_state VARCHAR(255) NOT NULL, price INT UNSIGNED NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_723705D1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', email VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bid ADD CONSTRAINT FK_4AF2B3F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bid DROP FOREIGN KEY FK_4AF2B3F3A76ED395');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A76ED395');
        $this->addSql('DROP TABLE bid');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user');
    }
}
