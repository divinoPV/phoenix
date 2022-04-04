<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220404075103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD deleted_by_id INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651CB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651CC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_7B00651CB03A8386 ON status (created_by_id)');
        $this->addSql('CREATE INDEX IDX_7B00651C896DBBDE ON status (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_7B00651CC76F1F52 ON status (deleted_by_id)');
        $this->addSql('ALTER TABLE team ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD deleted_by_id INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_C4E0A61FB03A8386 ON team (created_by_id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61F896DBBDE ON team (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61FC76F1F52 ON team (deleted_by_id)');
        $this->addSql('ALTER TABLE user ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD deleted_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_8D93D649B03A8386 ON user (created_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649896DBBDE ON user (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C76F1F52 ON user (deleted_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651CB03A8386');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C896DBBDE');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651CC76F1F52');
        $this->addSql('DROP INDEX IDX_7B00651CB03A8386 ON status');
        $this->addSql('DROP INDEX IDX_7B00651C896DBBDE ON status');
        $this->addSql('DROP INDEX IDX_7B00651CC76F1F52 ON status');
        $this->addSql('ALTER TABLE status DROP created_by_id, DROP updated_by_id, DROP deleted_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FB03A8386');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F896DBBDE');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FC76F1F52');
        $this->addSql('DROP INDEX IDX_C4E0A61FB03A8386 ON team');
        $this->addSql('DROP INDEX IDX_C4E0A61F896DBBDE ON team');
        $this->addSql('DROP INDEX IDX_C4E0A61FC76F1F52 ON team');
        $this->addSql('ALTER TABLE team DROP created_by_id, DROP updated_by_id, DROP deleted_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B03A8386');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649896DBBDE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C76F1F52');
        $this->addSql('DROP INDEX IDX_8D93D649B03A8386 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649896DBBDE ON user');
        $this->addSql('DROP INDEX IDX_8D93D649C76F1F52 ON user');
        $this->addSql('ALTER TABLE user DROP created_by_id, DROP updated_by_id, DROP deleted_by_id');
    }
}
