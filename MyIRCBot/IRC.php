<?php
namespace MyIRCBot;

use MyIRCBot\Entities\Attacks\Hadouken;
use MyIRCBot\Entities\State;
use MyIRCBot\Repositories\UserRepository;
use MyIRCBot\Utilities\IRCController;
use MyIRCBot\Utilities\StringTools;
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
			$rand = rand(1, 4000);
			//exec('php ' . __DIR__ . "/../start.php minion $rand> /dev/null &");
		}

		$this->bot->onMessages('/\$\([\'‘“`"][#\.](.*)[\'`’”"]\)\.(.*)\(\)/u', function(Event $event) {
			$matches = $event->getMatches();
			$username = $matches[0];
			$action = "action" . $matches[1];

			if (!isset($this->_users[$username]))
			{
				$user = new User();
				$user->setUsername($username);
				$this->_users[$username] = $user;
			}

			$sendingUser = $event->getRequest()->getSendingUser();
			if (!isset($this->_users[$sendingUser]))
			{
				$user = new User();
				$user->setUsername($sendingUser);
				$this->_users[$sendingUser] = $user;
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

		$user = $this->_users[$username];
		$sendingUser = $this->_users[$event->getRequest()->getSendingUser()];
		if ($sendingUser->isConfused())
		{
			$username = $sendingUser->getUsername();
			$msg = "$username punched himself in confusion." . $this->doDamage($sendingUser);
		}
		else
		{
			$msg = $this->doDamage($user);
		}


		if ($user->getIsMinion() && ($user->getHp() == 0))
		{
			$event->addResponse(Response::msg($user->getUsername(), 'killed'));
		}

		$this->muliLineMsg($event, $msg);
	}

	public function actionFlip(Event $event)
	{
		$matches = $event->getMatches();
		$username = $matches[0];
		$user = $this->_users[$username];

		$sendingUser = $this->_users[$event->getRequest()->getSendingUser()];

		if ($sendingUser->isConfused())
		{
			$sendingUsername = $sendingUser->getUsername();

			$event->addResponse(Response::action($event->getRequest()->getSource(),
				"$sendingUsername flipped itself in confusion (╯ಥ益ಥ）╯﻿︵ " . StringTools::flip($sendingUsername)));
		} else {
			$event->addResponse(Response::action($event->getRequest()->getSource(),
				"(╯ಥ益ಥ）╯﻿︵ " . StringTools::flip($user->getUsername())));
		}
	}

	public function actionHadouken(Event $event)
	{
		$matches = $event->getMatches();
		$username = $matches[0];
		$user = $this->_users[$username];

		$sendingUser = $this->_users[$event->getRequest()->getSendingUser()];

		$hadouken = new Hadouken();
		$hadouken->performAttack($sendingUser, $user);
		$msg = $hadouken->getDisplay($sendingUser, $user);

		$this->muliLineMsg($event, $msg);
	}

	public function actionConfuse(Event $event)
	{
		$matches = $event->getMatches();
		$username = $matches[0];
		$user = &$this->_users[$username];

		$msg = "";
		if ($user->isConfused())
		{
			$msg .= "$username is already CONFUSED!";
		} else {
			$msg .= "$username is now CONFUSED.";

			$user->addState(new State(State::CONFUSED));
			//$msg .= $this->doDamage($user);
		}

		$this->muliLineMsg($event, $msg);
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

	public function doDamage(User &$user)
	{
		$username = $user->getUsername();

		$maxHP = $user->getMaxHP();
		$damage = $user->doDamage(rand(0,40));
		$newHP = $user->getHP();

		$msg = "\n $username took $damage Damage. HP:$newHP/$maxHP";

		if ($newHP == 0) {
			$msg = "\n $username is KO'd";
		}

		return $msg;
	}

}