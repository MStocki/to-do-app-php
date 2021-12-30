<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230075501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_active DROP FOREIGN KEY FK_70B778D19D86650F');
        $this->addSql('DROP INDEX IDX_70B778D19D86650F ON task_active');
        $this->addSql('ALTER TABLE task_active CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_active ADD CONSTRAINT FK_70B778D1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_70B778D1A76ED395 ON task_active (user_id)');
        $this->addSql('ALTER TABLE task_archive DROP FOREIGN KEY FK_CA1D77769D86650F');
        $this->addSql('DROP INDEX IDX_CA1D77769D86650F ON task_archive');
        $this->addSql('ALTER TABLE task_archive CHANGE status status VARCHAR(255) NOT NULL, CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_archive ADD CONSTRAINT FK_CA1D7776A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CA1D7776A76ED395 ON task_archive (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_active DROP FOREIGN KEY FK_70B778D1A76ED395');
        $this->addSql('DROP INDEX IDX_70B778D1A76ED395 ON task_active');
        $this->addSql('ALTER TABLE task_active CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_active ADD CONSTRAINT FK_70B778D19D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_70B778D19D86650F ON task_active (user_id_id)');
        $this->addSql('ALTER TABLE task_archive DROP FOREIGN KEY FK_CA1D7776A76ED395');
        $this->addSql('DROP INDEX IDX_CA1D7776A76ED395 ON task_archive');
        $this->addSql('ALTER TABLE task_archive CHANGE status status VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_archive ADD CONSTRAINT FK_CA1D77769D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CA1D77769D86650F ON task_archive (user_id_id)');
    }
}
