<?php
namespace MyIRCBot;

use MyIRCBot\Repositories\UserRepository;
use MyIRCBot\Utilities\IRCController;
use Philip\IRC\Event;
use Philip\IRC\Response;
use Philip\Philip;
use MyIRCBot\Entities\User;

class IRC extends IRCController
{
	private $_config;

	/**
	 * @var User[]
	 */
	private $_users;

	/**
	 * @var Philip
	 */
	private $bot;

	private $userRepo;

	public function setConfig($config)
	{
		$this->_config = $config;
	}

	public function main()
	{
		$this->bot = new Philip($this->_config);

		for($i = 0; $i < 2; $i++)
		{
			exec('php ' . __DIR__ . '/../start.php minion > /dev/null &');
		}

		$this->bot->onMessages('/\$\([\'`"]#(.*)[\'`"]\)\.(.*)\(\)/', function($event) {
			$matches = $event->getMatches();
			$username = $matches[0];
			$action = "action" . $matches[1];

			if (!isset($this->_users[$username]))
			{
				$this->_users[$username] = new User();
			}

			if (method_exists($this, $action)){
				$this->$action($event);
			}

		});

		$this->help();
		$this->aggrigateData();

		$this->bot->run();
	}

	public function actionInvalid($event)
	{
		//display message for 'no-can-do'
	}

	public function actionPunch(Event $event)
	{
		$matches = $event->getMatches();
		$username = $matches[0];

		$msg = $this->doDamage($this->_users[$username], Actions::PUNCHED);

		$this->muliLineMsg($event, $msg);
	}

	public function doDamage(User &$user, $action)
	{
		$username = $user->getUsername();
		$initHP =  $user->getHP();
		$damage = $user->doDamage(rand(0,40));
		$newHP = $user->getHP();

		$msg = "========================";
		$msg .= "\n $username HP:$initHP";
		$msg .= "\n $username was $action and took $damage Damage";
		$msg .= "\n $username now has $newHP HP";
		$msg .= "\n ------------------------";

		return $msg;
	}

	public function aggrigateData()
	{
		$this->bot->onJoin(function(Event $event) {
			$request = $event->getRequest();
			$user = new User();
			$user->updateFromRequest($request);

			$this->_users[$user->getUsername()] = $user;
		});
	}

	public function help()
	{
		$this->bot->onMessages('/jQuery help/i', function($event) {
			$msg = "Available Commands:" .
			       "\n-------------------" .
			       "\n$('#username').punch();";

			$this->muliLineMsg($event, $msg);
		});
	}

	public function muliLineMsg($event, $msg)
	{
		$messages = explode("\n", $msg);

		foreach($messages as $message)
		{
			$event->addResponse(Response::msg(
				$event->getRequest()->getSource(),
				$message
			));
		}
	}

}