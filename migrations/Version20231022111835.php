<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231022111835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE parcel_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE parcel (id INT NOT NULL, sender_id INT NOT NULL, recipient_id INT NOT NULL, sender_address VARCHAR(255) NOT NULL, recipient_address VARCHAR(255) NOT NULL, dimensions JSON NOT NULL, estimated_cost INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C99B5D60F624B39D ON parcel (sender_id)');
        $this->addSql('CREATE INDEX IDX_C99B5D60E92F8F78 ON parcel (recipient_id)');
        $this->addSql('CREATE TABLE person (id INT NOT NULL, full_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE parcel ADD CONSTRAINT FK_C99B5D60F624B39D FOREIGN KEY (sender_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parcel ADD CONSTRAINT FK_C99B5D60E92F8F78 FOREIGN KEY (recipient_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE parcel_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_id_seq CASCADE');
        $this->addSql('ALTER TABLE parcel DROP CONSTRAINT FK_C99B5D60F624B39D');
        $this->addSql('ALTER TABLE parcel DROP CONSTRAINT FK_C99B5D60E92F8F78');
        $this->addSql('DROP TABLE parcel');
        $this->addSql('DROP TABLE person');
    }
}
