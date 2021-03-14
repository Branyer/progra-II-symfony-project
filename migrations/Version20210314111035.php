<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210314111035 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bill (id INT AUTO_INCREMENT NOT NULL, package_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_7A2119E3F44CABFF (package_id), INDEX IDX_7A2119E3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cable (id INT AUTO_INCREMENT NOT NULL, plan_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_24E9C4D4E899029B (plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE change_package_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, package_id INT DEFAULT NULL, INDEX IDX_84CBB416A76ED395 (user_id), INDEX IDX_84CBB416F44CABFF (package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE channel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE channel_program (channel_id INT NOT NULL, program_id INT NOT NULL, INDEX IDX_25AE488572F5A1AA (channel_id), INDEX IDX_25AE48853EB8070A (program_id), PRIMARY KEY(channel_id, program_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE internet (id INT AUTO_INCREMENT NOT NULL, speed INT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE package (id INT AUTO_INCREMENT NOT NULL, internet_id INT DEFAULT NULL, cable_id INT DEFAULT NULL, telephony_id INT DEFAULT NULL, discount DOUBLE PRECISION NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_DE686795DFF26D68 (internet_id), INDEX IDX_DE6867959A81106E (cable_id), INDEX IDX_DE686795E4AB720E (telephony_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan_channel (plan_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_1C46C64FE899029B (plan_id), INDEX IDX_1C46C64F72F5A1AA (channel_id), PRIMARY KEY(plan_id, channel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, week_day LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', hour TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telephony (id INT AUTO_INCREMENT NOT NULL, minutes INT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, package_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649F44CABFF (package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE week_day (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3F44CABFF FOREIGN KEY (package_id) REFERENCES package (id)');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cable ADD CONSTRAINT FK_24E9C4D4E899029B FOREIGN KEY (plan_id) REFERENCES plan (id)');
        $this->addSql('ALTER TABLE change_package_request ADD CONSTRAINT FK_84CBB416A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE change_package_request ADD CONSTRAINT FK_84CBB416F44CABFF FOREIGN KEY (package_id) REFERENCES package (id)');
        $this->addSql('ALTER TABLE channel_program ADD CONSTRAINT FK_25AE488572F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE channel_program ADD CONSTRAINT FK_25AE48853EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795DFF26D68 FOREIGN KEY (internet_id) REFERENCES internet (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE6867959A81106E FOREIGN KEY (cable_id) REFERENCES cable (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795E4AB720E FOREIGN KEY (telephony_id) REFERENCES telephony (id)');
        $this->addSql('ALTER TABLE plan_channel ADD CONSTRAINT FK_1C46C64FE899029B FOREIGN KEY (plan_id) REFERENCES plan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_channel ADD CONSTRAINT FK_1C46C64F72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F44CABFF FOREIGN KEY (package_id) REFERENCES package (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE6867959A81106E');
        $this->addSql('ALTER TABLE channel_program DROP FOREIGN KEY FK_25AE488572F5A1AA');
        $this->addSql('ALTER TABLE plan_channel DROP FOREIGN KEY FK_1C46C64F72F5A1AA');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795DFF26D68');
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E3F44CABFF');
        $this->addSql('ALTER TABLE change_package_request DROP FOREIGN KEY FK_84CBB416F44CABFF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F44CABFF');
        $this->addSql('ALTER TABLE cable DROP FOREIGN KEY FK_24E9C4D4E899029B');
        $this->addSql('ALTER TABLE plan_channel DROP FOREIGN KEY FK_1C46C64FE899029B');
        $this->addSql('ALTER TABLE channel_program DROP FOREIGN KEY FK_25AE48853EB8070A');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795E4AB720E');
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E3A76ED395');
        $this->addSql('ALTER TABLE change_package_request DROP FOREIGN KEY FK_84CBB416A76ED395');
        $this->addSql('DROP TABLE bill');
        $this->addSql('DROP TABLE cable');
        $this->addSql('DROP TABLE change_package_request');
        $this->addSql('DROP TABLE channel');
        $this->addSql('DROP TABLE channel_program');
        $this->addSql('DROP TABLE internet');
        $this->addSql('DROP TABLE package');
        $this->addSql('DROP TABLE plan');
        $this->addSql('DROP TABLE plan_channel');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE telephony');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE week_day');
    }
}
