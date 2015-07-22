<?php

namespace MyIRCBot;

use Philip\Philip;

class Minion
{
	private $bot;

	private $config;

	public function main()
	{
		$this->bot = new Philip($this->config);

		$this->bot->run();
	}

	public function setConfig($config)
	{
		$config = include(__DIR__ . '/../config/irc.php');

		$username = 'Minion'.  rand(1, 4000);
		$config['username'] = $username;
		$config['nick'] = $username;

		$this->config = $config;
	}
}