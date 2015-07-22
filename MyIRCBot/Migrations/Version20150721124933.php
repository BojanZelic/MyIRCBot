<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150721124933 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE `User` (
          `id` int(11) NOT NULL,
          `ip_address` varchar(45) DEFAULT NULL,
          `username` varchar(45) DEFAULT NULL,
          `MaxHP` decimal(2,0) DEFAULT NULL,
          `HP` decimal(2,0) DEFAULT NULL,
          `Level` decimal(2,0) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('User');
    }
}
