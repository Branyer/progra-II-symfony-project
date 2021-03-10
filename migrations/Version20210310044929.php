<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310044929 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cable (id INT AUTO_INCREMENT NOT NULL, plan_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_24E9C4D4E899029B (plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE channel (id INT AUTO_INCREMENT NOT NULL, plan_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A2F98E47E899029B (plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE internet (id INT AUTO_INCREMENT NOT NULL, speed INT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE package (id INT AUTO_INCREMENT NOT NULL, cable_id INT NOT NULL, internet_id INT NOT NULL, telephony_id INT NOT NULL, discount DOUBLE PRECISION NOT NULL, INDEX IDX_DE6867959A81106E (cable_id), INDEX IDX_DE686795DFF26D68 (internet_id), INDEX IDX_DE686795E4AB720E (telephony_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, channel_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, hour TIME NOT NULL, week_day LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_92ED778472F5A1AA (channel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telephony (id INT AUTO_INCREMENT NOT NULL, minutes INT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE week_day (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cable ADD CONSTRAINT FK_24E9C4D4E899029B FOREIGN KEY (plan_id) REFERENCES plan (id)');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E47E899029B FOREIGN KEY (plan_id) REFERENCES plan (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE6867959A81106E FOREIGN KEY (cable_id) REFERENCES cable (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795DFF26D68 FOREIGN KEY (internet_id) REFERENCES internet (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795E4AB720E FOREIGN KEY (telephony_id) REFERENCES telephony (id)');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED778472F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE6867959A81106E');
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED778472F5A1AA');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795DFF26D68');
        $this->addSql('ALTER TABLE cable DROP FOREIGN KEY FK_24E9C4D4E899029B');
        $this->addSql('ALTER TABLE channel DROP FOREIGN KEY FK_A2F98E47E899029B');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795E4AB720E');
        $this->addSql('DROP TABLE cable');
        $this->addSql('DROP TABLE channel');
        $this->addSql('DROP TABLE internet');
        $this->addSql('DROP TABLE package');
        $this->addSql('DROP TABLE plan');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE telephony');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE week_day');
    }
}
