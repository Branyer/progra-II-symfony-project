<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309012508 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cable (id INT AUTO_INCREMENT NOT NULL, plan_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_24E9C4D4E899029B (plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE package (id INT AUTO_INCREMENT NOT NULL, cable_id INT NOT NULL, internet_id INT NOT NULL, telephony_id INT NOT NULL, discount DOUBLE PRECISION NOT NULL, INDEX IDX_DE6867959A81106E (cable_id), INDEX IDX_DE686795DFF26D68 (internet_id), INDEX IDX_DE686795E4AB720E (telephony_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cable ADD CONSTRAINT FK_24E9C4D4E899029B FOREIGN KEY (plan_id) REFERENCES plan (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE6867959A81106E FOREIGN KEY (cable_id) REFERENCES cable (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795DFF26D68 FOREIGN KEY (internet_id) REFERENCES internet (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795E4AB720E FOREIGN KEY (telephony_id) REFERENCES telephony (id)');
        $this->addSql('ALTER TABLE channel ADD plan_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E472CE2DBAB FOREIGN KEY (plan_id_id) REFERENCES plan (id)');
        $this->addSql('CREATE INDEX IDX_A2F98E472CE2DBAB ON channel (plan_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE6867959A81106E');
        $this->addSql('ALTER TABLE cable DROP FOREIGN KEY FK_24E9C4D4E899029B');
        $this->addSql('ALTER TABLE channel DROP FOREIGN KEY FK_A2F98E472CE2DBAB');
        $this->addSql('DROP TABLE cable');
        $this->addSql('DROP TABLE package');
        $this->addSql('DROP TABLE plan');
        $this->addSql('DROP INDEX IDX_A2F98E472CE2DBAB ON channel');
        $this->addSql('ALTER TABLE channel DROP plan_id_id');
    }
}
