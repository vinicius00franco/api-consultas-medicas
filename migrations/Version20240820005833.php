<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820005833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        if (!$schema->hasTable('beneficiario')) {
            $this->addSql('CREATE TABLE beneficiario (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, data_nascimento DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        }
    
        if (!$schema->hasTable('hospital')) {
            $this->addSql('CREATE TABLE hospital (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, endereco VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        }
    
        if (!$schema->hasTable('medico')) {
            $this->addSql('CREATE TABLE medico (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, especialidade VARCHAR(255) NOT NULL, hospital_id INT NOT NULL, INDEX IDX_34E5914C63DBB69 (hospital_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        }
    
        if (!$schema->hasTable('consulta')) {
            $this->addSql('CREATE TABLE consulta (id INT AUTO_INCREMENT NOT NULL, data DATETIME NOT NULL, status VARCHAR(50) NOT NULL, beneficiario_id INT NOT NULL, medico_id INT NOT NULL, hospital_id INT NOT NULL, INDEX IDX_A6FE3FDE4B64ABC7 (beneficiario_id), INDEX IDX_A6FE3FDEA7FB1C0C (medico_id), INDEX IDX_A6FE3FDE63DBB69 (hospital_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        }
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE beneficiario (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, data_nascimento DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE consulta (id INT AUTO_INCREMENT NOT NULL, data DATETIME NOT NULL, status VARCHAR(50) NOT NULL, beneficiario_id INT NOT NULL, medico_id INT NOT NULL, hospital_id INT NOT NULL, INDEX IDX_A6FE3FDE4B64ABC7 (beneficiario_id), INDEX IDX_A6FE3FDEA7FB1C0C (medico_id), INDEX IDX_A6FE3FDE63DBB69 (hospital_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE hospital (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, endereco VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE medico (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, especialidade VARCHAR(255) NOT NULL, hospital_id INT NOT NULL, INDEX IDX_34E5914C63DBB69 (hospital_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        
        
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE4B64ABC7 FOREIGN KEY (beneficiario_id) REFERENCES beneficiario (id)');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDEA7FB1C0C FOREIGN KEY (medico_id) REFERENCES medico (id)');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE63DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id)');
        $this->addSql('ALTER TABLE medico ADD CONSTRAINT FK_34E5914C63DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE4B64ABC7');
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDEA7FB1C0C');
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE63DBB69');
        $this->addSql('ALTER TABLE medico DROP FOREIGN KEY FK_34E5914C63DBB69');
        $this->addSql('DROP TABLE beneficiario');
        $this->addSql('DROP TABLE consulta');
        $this->addSql('DROP TABLE hospital');
        $this->addSql('DROP TABLE medico');
    }
}
