<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200428150256 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cities ADD department_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16BAE80F5DF FOREIGN KEY (department_id) REFERENCES departments (id)');
        $this->addSql('CREATE INDEX IDX_D95DB16BAE80F5DF ON cities (department_id)');
        $this->addSql('ALTER TABLE departments ADD region_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE departments ADD CONSTRAINT FK_16AEB8D498260155 FOREIGN KEY (region_id) REFERENCES regions (id)');
        $this->addSql('CREATE INDEX IDX_16AEB8D498260155 ON departments (region_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16BAE80F5DF');
        $this->addSql('DROP INDEX IDX_D95DB16BAE80F5DF ON cities');
        $this->addSql('ALTER TABLE cities DROP department_id');
        $this->addSql('ALTER TABLE departments DROP FOREIGN KEY FK_16AEB8D498260155');
        $this->addSql('DROP INDEX IDX_16AEB8D498260155 ON departments');
        $this->addSql('ALTER TABLE departments DROP region_id');
    }
}
