<?php

namespace MyIRCBot;

use Philip\IRC\Event;
use Philip\IRC\Response;
use Philip\Philip;

class Cleverbot
{
	/**
	 * @var Philip
	 */
	private $bot;

	private $config;

	public function main()
	{
		$this->bot = new Philip($this->config);

		$factory = new \ChatterBotFactory();
		$clever  = $factory->create(\ChatterBotType::PANDORABOTS, 'b0dafd24ee35a477');
		$session = $clever->createSession();

		$this->bot->onMessages('/ai(.*)/u', function (Event $event) use (&$clever, &$session)
		{
			$matches = $event->getMatches();
			$message = $matches[0];

			$response = "";

			try
			{
				$response = $session->think($message);
			}
			catch (\Exception $e)
			{
				$response = "I can't reach the Cloud. I don't know how to answer";
				$session = $clever->createSession();
			}
			$event->addResponse(
				Response::msg($event->getRequest()->getSource(), $response));
		});

		$this->bot->run();
	}

	public function setConfig($config)
	{
		$config['username'] = "ai";
		$config['nick'] = "ai";

		$this->config = $config;
	}
}