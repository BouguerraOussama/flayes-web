<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240501212134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_E817A83A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_E817A83AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE user_id user_id INT NOT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE added_date added_date DATE DEFAULT NULL, CHANGE end_date end_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP INDEX fk_userid_id ON project');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEA76ED395 ON project (user_id)');
        $this->addSql('ALTER TABLE user ADD email VARCHAR(255) NOT NULL, CHANGE user_name user_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Offer DROP FOREIGN KEY FK_E817A83A166D1F9C');
        $this->addSql('ALTER TABLE Offer DROP FOREIGN KEY FK_E817A83AA76ED395');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEA76ED395');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEA76ED395');
        $this->addSql('ALTER TABLE project CHANGE user_id user_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE description description TEXT NOT NULL, CHANGE type type VARCHAR(255) NOT NULL, CHANGE status status TINYINT(1) NOT NULL, CHANGE added_date added_date DATE NOT NULL, CHANGE end_date end_date DATE NOT NULL');
        $this->addSql('DROP INDEX idx_2fb3d0eea76ed395 ON project');
        $this->addSql('CREATE INDEX fk_userID_id ON project (user_id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user DROP email, CHANGE user_name user_name VARCHAR(255) NOT NULL');
    }
}
