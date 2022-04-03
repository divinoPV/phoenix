<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220403215413 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budget (uuid VARCHAR(255) NOT NULL, original INT NOT NULL, consumed INT NOT NULL, remaining INT NOT NULL, landing INT NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fact (uuid VARCHAR(255) NOT NULL, project_id VARCHAR(255) NOT NULL, occurred DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, milestone VARCHAR(255) NOT NULL, INDEX IDX_6FA45B95166D1F9C (project_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio (uuid VARCHAR(255) NOT NULL, responsible_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A9ED1062602AD315 (responsible_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (uuid VARCHAR(255) NOT NULL, status_id VARCHAR(255) NOT NULL, portfolio_id VARCHAR(255) NOT NULL, budget_id VARCHAR(255) NOT NULL, team_project_id VARCHAR(255) NOT NULL, team_customer_id VARCHAR(255) NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, code VARCHAR(255) NOT NULL, archived TINYINT(1) NOT NULL, started_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ended_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_2FB3D0EE6BF700BD (status_id), INDEX IDX_2FB3D0EEB96B5643 (portfolio_id), INDEX IDX_2FB3D0EE36ABA6B8 (budget_id), INDEX IDX_2FB3D0EE28B46D59 (team_project_id), INDEX IDX_2FB3D0EE78A52CBE (team_customer_id), INDEX IDX_2FB3D0EEB03A8386 (created_by_id), INDEX IDX_2FB3D0EE896DBBDE (updated_by_id), INDEX IDX_2FB3D0EEC76F1F52 (deleted_by_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE risk (uuid VARCHAR(255) NOT NULL, project_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, identification DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', resolution DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', probability VARCHAR(255) NOT NULL, severity VARCHAR(255) NOT NULL, INDEX IDX_7906D541166D1F9C (project_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (uuid VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(7) NOT NULL, placement INT NOT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (uuid VARCHAR(255) NOT NULL, responsible_id INT NOT NULL, parent_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_C4E0A61F602AD315 (responsible_id), INDEX IDX_C4E0A61F727ACA70 (parent_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, team_id VARCHAR(255) DEFAULT NULL, email VARCHAR(180) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, user_name VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fact ADD CONSTRAINT FK_6FA45B95166D1F9C FOREIGN KEY (project_id) REFERENCES project (uuid)');
        $this->addSql('ALTER TABLE portfolio ADD CONSTRAINT FK_A9ED1062602AD315 FOREIGN KEY (responsible_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE6BF700BD FOREIGN KEY (status_id) REFERENCES status (uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEB96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE36ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE28B46D59 FOREIGN KEY (team_project_id) REFERENCES team (uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE78A52CBE FOREIGN KEY (team_customer_id) REFERENCES team (uuid)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE risk ADD CONSTRAINT FK_7906D541166D1F9C FOREIGN KEY (project_id) REFERENCES project (uuid)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F602AD315 FOREIGN KEY (responsible_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F727ACA70 FOREIGN KEY (parent_id) REFERENCES team (uuid)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649296CD8AE FOREIGN KEY (team_id) REFERENCES team (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE36ABA6B8');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEB96B5643');
        $this->addSql('ALTER TABLE fact DROP FOREIGN KEY FK_6FA45B95166D1F9C');
        $this->addSql('ALTER TABLE risk DROP FOREIGN KEY FK_7906D541166D1F9C');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE6BF700BD');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE28B46D59');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE78A52CBE');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F727ACA70');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649296CD8AE');
        $this->addSql('ALTER TABLE portfolio DROP FOREIGN KEY FK_A9ED1062602AD315');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEB03A8386');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE896DBBDE');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEC76F1F52');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F602AD315');
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP TABLE fact');
        $this->addSql('DROP TABLE portfolio');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE risk');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE user');
    }
}
