<?php

namespace MyIRCBot\Utilities;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class IRCController
{
	public $container;

	private $em;

	/**
	 * @return EntityManager
	 */
	public function getEm()
	{
		if(!isset($this->em))
		{
			$this->setEm();
		}

		return $this->em;
	}

	protected function setEm()
	{
		$paths = array(__DIR__ . "/MyIRCBot/Entities");

		$isDevMode = false;

		// the connection configuration
		$dbParams = require_once(__DIR__ . '/../../config/db.php');

		// Any way to access the EntityManager from your application
		$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
		$this->em = EntityManager::create($dbParams, $config);
	}

}