<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311082243 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plan_channel (plan_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_1C46C64FE899029B (plan_id), INDEX IDX_1C46C64F72F5A1AA (channel_id), PRIMARY KEY(plan_id, channel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plan_channel ADD CONSTRAINT FK_1C46C64FE899029B FOREIGN KEY (plan_id) REFERENCES plan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_channel ADD CONSTRAINT FK_1C46C64F72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cable DROP INDEX IDX_24E9C4D4E899029B, ADD UNIQUE INDEX UNIQ_24E9C4D4E899029B (plan_id)');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE6867959A81106E');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795DFF26D68');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795E4AB720E');
        $this->addSql('DROP INDEX IDX_DE6867959A81106E ON package');
        $this->addSql('DROP INDEX IDX_DE686795DFF26D68 ON package');
        $this->addSql('DROP INDEX IDX_DE686795E4AB720E ON package');
        $this->addSql('ALTER TABLE package DROP cable_id, DROP internet_id, DROP telephony_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE plan_channel');
        $this->addSql('ALTER TABLE cable DROP INDEX UNIQ_24E9C4D4E899029B, ADD INDEX IDX_24E9C4D4E899029B (plan_id)');
        $this->addSql('ALTER TABLE package ADD cable_id INT NOT NULL, ADD internet_id INT NOT NULL, ADD telephony_id INT NOT NULL');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE6867959A81106E FOREIGN KEY (cable_id) REFERENCES cable (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795DFF26D68 FOREIGN KEY (internet_id) REFERENCES internet (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795E4AB720E FOREIGN KEY (telephony_id) REFERENCES telephony (id)');
        $this->addSql('CREATE INDEX IDX_DE6867959A81106E ON package (cable_id)');
        $this->addSql('CREATE INDEX IDX_DE686795DFF26D68 ON package (internet_id)');
        $this->addSql('CREATE INDEX IDX_DE686795E4AB720E ON package (telephony_id)');
    }
}
