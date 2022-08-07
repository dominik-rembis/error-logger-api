<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220806121722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_data (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:user_data_uuid)\', name VARCHAR(50) NOT NULL, surname VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(96) NOT NULL, UNIQUE INDEX UNIQ_D772BFAAE7927C74 (email), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_group (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:user_group_uuid)\', name VARCHAR(50) NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_group_aggregate (user_group_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:user_group_uuid)\', user_data_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:user_data_uuid)\', INDEX IDX_651679915F42CD3A (user_group_uuid), INDEX IDX_651679916AD016A0 (user_data_uuid), PRIMARY KEY(user_group_uuid, user_data_uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_group_aggregate ADD CONSTRAINT FK_651679915F42CD3A FOREIGN KEY (user_group_uuid) REFERENCES user_group (uuid)');
        $this->addSql('ALTER TABLE user_group_aggregate ADD CONSTRAINT FK_651679916AD016A0 FOREIGN KEY (user_data_uuid) REFERENCES user_data (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_group_aggregate DROP FOREIGN KEY FK_651679916AD016A0');
        $this->addSql('ALTER TABLE user_group_aggregate DROP FOREIGN KEY FK_651679915F42CD3A');
        $this->addSql('DROP TABLE user_data');
        $this->addSql('DROP TABLE user_group');
        $this->addSql('DROP TABLE user_group_aggregate');
    }
}
