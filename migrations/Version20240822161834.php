<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240822161834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE4B64ABC7');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE4B64ABC7 FOREIGN KEY (beneficiario_id) REFERENCES beneficiario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medico ADD ativo TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE4B64ABC7');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE4B64ABC7 FOREIGN KEY (beneficiario_id) REFERENCES beneficiario (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE medico DROP ativo');
    }
}
