<?php
require_once('bootstrap.php');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array(__DIR__."/../MyIRCBot/Entities");
$isDevMode = false;

// the connection configuration
$dbParams = require_once('db.php');

// Any way to access the EntityManager from your application
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
$em = EntityManager::create($dbParams, $config);

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
	'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
	'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

$cli = new \Symfony\Component\Console\Application('Doctrine Command Line Interface', \Doctrine\ORM\Version::VERSION);
$cli->setCatchExceptions(true);
$cli->setHelperSet($helperSet);

// Register All Doctrine Commands
$cli->addCommands(array(
	// ...

	// Migrations Commands
	new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand(),
	new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand(),
	new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand(),
	new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand(),
	new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand(),
	new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand()
));

return $helperSet;