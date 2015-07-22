<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150721124746 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
	    $this->addSql("CREATE TABLE `Attacks` (
			  `id` int(11) NOT NULL,
			  `Name` varchar(45) DEFAULT NULL,
			  `Strength` decimal(5,0) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
	    $schema->dropTable('Attacks');
    }
}
