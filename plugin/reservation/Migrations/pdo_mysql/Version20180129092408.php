<?php

namespace FormaLibre\ReservationBundle\Migrations\pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution.
 *
 * Generation date: 2018/01/29 09:24:10
 */
class Version20180129092408 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
            CREATE TABLE formalibre_reservation_resource_organizations (
                resource_id INT NOT NULL, 
                organization_id INT NOT NULL, 
                INDEX IDX_110DC6D989329D25 (resource_id), 
                INDEX IDX_110DC6D932C8A3DE (organization_id), 
                PRIMARY KEY(resource_id, organization_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            ALTER TABLE formalibre_reservation_resource_organizations 
            ADD CONSTRAINT FK_110DC6D989329D25 FOREIGN KEY (resource_id) 
            REFERENCES formalibre_reservation_resource (id) 
            ON DELETE CASCADE
        ');
        $this->addSql('
            ALTER TABLE formalibre_reservation_resource_organizations 
            ADD CONSTRAINT FK_110DC6D932C8A3DE FOREIGN KEY (organization_id) 
            REFERENCES claro__organization (id) 
            ON DELETE CASCADE
        ');
    }

    public function down(Schema $schema)
    {
        $this->addSql('
            DROP TABLE formalibre_reservation_resource_organizations
        ');
    }
}
