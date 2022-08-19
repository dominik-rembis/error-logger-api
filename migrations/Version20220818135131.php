<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220818135131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE account (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:account_uuid)\', name VARCHAR(50) NOT NULL, surname VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(96) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json_role)\', is_active TINYINT(1) DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_7D3656A4E7927C74 (email), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aggregate (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:aggregate_uuid)\', name VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_B77949FF5E237E06 (name), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account_aggregate (aggregate_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:aggregate_uuid)\', account_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:account_uuid)\', INDEX IDX_950391A450869B26 (aggregate_uuid), INDEX IDX_950391A45DECD70C (account_uuid), PRIMARY KEY(aggregate_uuid, account_uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account_aggregate ADD CONSTRAINT FK_950391A450869B26 FOREIGN KEY (aggregate_uuid) REFERENCES aggregate (uuid)');
        $this->addSql('ALTER TABLE account_aggregate ADD CONSTRAINT FK_950391A45DECD70C FOREIGN KEY (account_uuid) REFERENCES account (uuid)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE account_aggregate DROP FOREIGN KEY FK_950391A450869B26');
        $this->addSql('ALTER TABLE account_aggregate DROP FOREIGN KEY FK_950391A45DECD70C');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE aggregate');
        $this->addSql('DROP TABLE account_aggregate');
    }
}
