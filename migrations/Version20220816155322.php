<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220816155322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:account_uuid)\', name VARCHAR(50) NOT NULL, surname VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(96) NOT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_7D3656A4E7927C74 (email), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_group (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:user_group_uuid)\', name VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8F02BF9D5E237E06 (name), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_group_aggregate (user_group_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:user_group_uuid)\', account_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:account_uuid)\', INDEX IDX_651679915F42CD3A (user_group_uuid), INDEX IDX_651679915DECD70C (account_uuid), PRIMARY KEY(user_group_uuid, account_uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_group_aggregate ADD CONSTRAINT FK_651679915F42CD3A FOREIGN KEY (user_group_uuid) REFERENCES user_group (uuid)');
        $this->addSql('ALTER TABLE user_group_aggregate ADD CONSTRAINT FK_651679915DECD70C FOREIGN KEY (account_uuid) REFERENCES account (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_group_aggregate DROP FOREIGN KEY FK_651679915DECD70C');
        $this->addSql('ALTER TABLE user_group_aggregate DROP FOREIGN KEY FK_651679915F42CD3A');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE user_group');
        $this->addSql('DROP TABLE user_group_aggregate');
    }
}
