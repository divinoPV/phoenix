<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222195254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budget (uuid VARCHAR(255) NOT NULL, original INT NOT NULL, consumed INT NOT NULL, remaining INT NOT NULL, landing INT NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fact (uuid VARCHAR(255) NOT NULL, milestone_id VARCHAR(255) NOT NULL, occurred DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_6FA45B954B3E2EDA (milestone_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE milestone (uuid VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, mandatory TINYINT(1) NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio (uuid VARCHAR(255) NOT NULL, responsible_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A9ED1062602AD315 (responsible_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE probability (uuid VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (uuid VARCHAR(255) NOT NULL, status_id VARCHAR(255) NOT NULL, portfolio_id VARCHAR(255) NOT NULL, budget_id VARCHAR(255) NOT NULL, team_project_id VARCHAR(255) NOT NULL, team_customer_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, code VARCHAR(255) NOT NULL, started_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ended_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_2FB3D0EE6BF700BD (status_id), INDEX IDX_2FB3D0EEB96B5643 (portfolio_id), INDEX IDX_2FB3D0EE36ABA6B8 (budget_id), INDEX IDX_2FB3D0EE28B46D59 (team_project_id), INDEX IDX_2FB3D0EE78A52CBE (team_customer_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE risk (uuid VARCHAR(255) NOT NULL, probability_id VARCHAR(255) NOT NULL, severity_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, identification DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', resolution DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7906D541D09E6F09 (probability_id), INDEX IDX_7906D541F7527401 (severity_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE severity (uuid VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (uuid VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, placement INT NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_customer (uuid VARCHAR(255) NOT NULL, responsible_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_397B5277602AD315 (responsible_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_project (uuid VARCHAR(255) NOT NULL, responsible_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D0CAA1D9602AD315 (responsible_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (uuid VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, team_id VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649296CD8AE (team_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fact ADD CONSTRAINT FK_6FA45B954B3E2EDA FOREIGN KEY (milestone_id) REFERENCES milestone (uuid)');
        $this->addSql('ALTER TABLE portfolio ADD CONSTRAINT FK_A9ED1062602AD315 FOREIGN KEY (responsible_id) REFERENCES user (uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE6BF700BD FOREIGN KEY (status_id) REFERENCES status (uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEB96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE36ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE28B46D59 FOREIGN KEY (team_project_id) REFERENCES team_project (uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE78A52CBE FOREIGN KEY (team_customer_id) REFERENCES team_customer (uuid)');
        $this->addSql('ALTER TABLE risk ADD CONSTRAINT FK_7906D541D09E6F09 FOREIGN KEY (probability_id) REFERENCES probability (uuid)');
        $this->addSql('ALTER TABLE risk ADD CONSTRAINT FK_7906D541F7527401 FOREIGN KEY (severity_id) REFERENCES severity (uuid)');
        $this->addSql('ALTER TABLE team_customer ADD CONSTRAINT FK_397B5277602AD315 FOREIGN KEY (responsible_id) REFERENCES user (uuid)');
        $this->addSql('ALTER TABLE team_project ADD CONSTRAINT FK_D0CAA1D9602AD315 FOREIGN KEY (responsible_id) REFERENCES user (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE36ABA6B8');
        $this->addSql('ALTER TABLE fact DROP FOREIGN KEY FK_6FA45B954B3E2EDA');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEB96B5643');
        $this->addSql('ALTER TABLE risk DROP FOREIGN KEY FK_7906D541D09E6F09');
        $this->addSql('ALTER TABLE risk DROP FOREIGN KEY FK_7906D541F7527401');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE6BF700BD');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE78A52CBE');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE28B46D59');
        $this->addSql('ALTER TABLE portfolio DROP FOREIGN KEY FK_A9ED1062602AD315');
        $this->addSql('ALTER TABLE team_customer DROP FOREIGN KEY FK_397B5277602AD315');
        $this->addSql('ALTER TABLE team_project DROP FOREIGN KEY FK_D0CAA1D9602AD315');
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP TABLE fact');
        $this->addSql('DROP TABLE milestone');
        $this->addSql('DROP TABLE portfolio');
        $this->addSql('DROP TABLE probability');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE risk');
        $this->addSql('DROP TABLE severity');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE team_customer');
        $this->addSql('DROP TABLE team_project');
        $this->addSql('DROP TABLE user');
    }
}
