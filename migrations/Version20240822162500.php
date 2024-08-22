<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240822162500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE63DBB69');
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDEA7FB1C0C');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE63DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDEA7FB1C0C FOREIGN KEY (medico_id) REFERENCES medico (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medico DROP FOREIGN KEY FK_34E5914C63DBB69');
        $this->addSql('ALTER TABLE medico ADD CONSTRAINT FK_34E5914C63DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDEA7FB1C0C');
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE63DBB69');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDEA7FB1C0C FOREIGN KEY (medico_id) REFERENCES medico (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE63DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE medico DROP FOREIGN KEY FK_34E5914C63DBB69');
        $this->addSql('ALTER TABLE medico ADD CONSTRAINT FK_34E5914C63DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
