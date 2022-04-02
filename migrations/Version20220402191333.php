<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220402191333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update risk and project tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project_risk');
        $this->addSql('ALTER TABLE risk ADD project_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE risk ADD CONSTRAINT FK_7906D541166D1F9C FOREIGN KEY (project_id) REFERENCES project (uuid)');
        $this->addSql('CREATE INDEX IDX_7906D541166D1F9C ON risk (project_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_risk (project_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, risk_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_40971D59166D1F9C (project_id), INDEX IDX_40971D59235B6D1 (risk_id), PRIMARY KEY(project_id, risk_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE project_risk ADD CONSTRAINT FK_40971D59166D1F9C FOREIGN KEY (project_id) REFERENCES project (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE project_risk ADD CONSTRAINT FK_40971D59235B6D1 FOREIGN KEY (risk_id) REFERENCES risk (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE risk DROP FOREIGN KEY FK_7906D541166D1F9C');
        $this->addSql('DROP INDEX IDX_7906D541166D1F9C ON risk');
        $this->addSql('ALTER TABLE risk DROP project_id');
    }
}
