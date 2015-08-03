<?php

namespace MyIRCBot;

use Philip\Philip;

class Minion
{
	/**
	 * @var Philip
	 */
	private $bot;

	private $config;
	private $minionNum;

	public function __construct($minionNum)
	{
		$this->minionNum = $minionNum;
	}

	public function main()
	{
		$this->bot = new Philip($this->config);
		$this->setActionKilled();

		$this->bot->run();
	}

	private function setActionKilled()
	{
		$this->bot->onPrivateMessage("/killed/", function($response) {
			//do validation to make sure it came from authorized user
			$this->bot->askStop();
		});
	}

	public function setConfig($config)
	{
		$username = "Minion" . $this->minionNum;
		$config['username'] = $username;
		$config['nick'] = $username;

		$this->config = $config;
	}
}