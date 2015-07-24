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

		$this->bot->run();
	}

	public function SetActionKilled()
	{
		$this->bot->onPrivateMessage("/killed/", function($response) {

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