<?php
namespace MyIRCBot;

use MyIRCBot\Entities\Attacks\Flip;
use MyIRCBot\Entities\Attacks\Hadouken;
use MyIRCBot\Entities\Attacks\Punch;
use MyIRCBot\Entities\State;
use MyIRCBot\Repositories\UserRepository;
use MyIRCBot\Utilities\IRCController;
use MyIRCBot\Utilities\StringTools;
use MyIRCBot\Entities\User;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Slim;

class IRC extends IRCController
{
	//private $_config;

	private $app;

	/**
	 * @var User[]
	 */
	private $_users;

	private $userRepo;

	public function main()
	{
		$this->app = new Slim();
		$app = $this->app;

		$this->app->any("/slack", function () use ($app)
		{
			$post = $_REQUEST;
			$response = $app->response();
			$response['Content-Type'] = 'application/json';
			$response->status(200);

			if($post['token'] !== "hG235FjlUjsg5CVDybDcGphW")
			{
				$response->body(json_encode(array('text' => 'Invalid Token')));
				return;
			}

			$command = $post['text'];
			$matches = explode(" ", $command);

			$sendingUser = $post['user_name'];

			if (count($matches) !== 3)
			{
				$response->body(json_encode(array('text' => 'Invalid Usage')));
				return;
			}

			$username = $this->_getReceivingUser($app->request);
			$action = $this->_getAction($app->request);

			if(!isset($this->_users[$username]))
			{
				$user = new User();
				$user->setUsername($username);
				$this->_users[$username] = $user;
			}

			if(!isset($this->_users[$sendingUser]))
			{
				$user = new User();
				$user->setUsername($sendingUser);
				$this->_users[$sendingUser] = $user;
			}

			if(method_exists($this, $action))
			{
				$message = $this->$action($app->request);
				$response->body(json_encode(array('text' => $message)));
				return;
			}

			$response->body(json_encode(array('text' => 'Invalid Usage')));
		});

		//$this->help();
		//$this->aggrigateData();

		$this->app->run();
	}

	private function _getReceivingUser(Request $request)
	{
		$text = $request->params('text');
		$matches = explode(" ", $text);

		return $matches[2];
	}

	private function _getAction(Request $request)
	{
		$text = $request->params('text');
		$matches = explode(" ", $text);

		return "action" . $matches[1];
	}

	public function actionInvalid($event)
	{
		//display message for 'no-can-do'
	}

	public function actionPunch(Request $request)
	{
		$username = $this->_getReceivingUser($request);

		$user = $this->_users[$username];
		$sendingUser = $this->_users[$request->params('user_name')];

		$punch = new Punch();
		$punch->performAttack($sendingUser, $user);
		$msg = $punch->getDisplay($sendingUser, $user);
		return $msg;
	}

	public function actionFlip(Request $request)
	{
		$username = $this->_getReceivingUser($request);
		$user = $this->_users[$username];

		$sendingUser = $this->_users[$request->params('user_name')];

		$flip = new Flip();
		$flip->performAttack($sendingUser, $user);
		$msg = $flip->getDisplay($sendingUser, $user);

		return $msg;
	}

	public function actionHadouken(Request $request)
	{
		$username = $this->_getReceivingUser($request);

		$user = $this->_users[$username];

		$sendingUser = $this->_users[$request->params('user_name')];

		$hadouken = new Hadouken();
		$hadouken->performAttack($sendingUser, $user);
		$msg = $hadouken->getDisplay($sendingUser, $user);

		return $msg;
	}

	public function actionConfuse(Request $request)
	{
		$username = $this->_getReceivingUser($request);

		$user = &$this->_users[$username];

		$msg = "";
		if($user->isConfused())
		{
			$msg .= "$username is already CONFUSED!";
		}
		else
		{
			$msg .= "$username is now CONFUSED.";

			$user->addState(new State(State::CONFUSED));
		}

		return $msg;
	}

	public function aggrigateData()
	{
		$this->bot->onJoin(function (Event $event)
		{
			$request = $event->getRequest();
			$user = new User();
			$user->updateFromRequest($request);

			$this->_users[$user->getUsername()] = $user;
		});
	}

	public function help()
	{
		//		$this->bot->onMessages('/jQuery help/i', function($event) {
		//			$msg = "Available Commands:" .
		//			       "\n-------------------" .
		//			       "\n$('#username').punch();";
		//
		//			$this->muliLineMsg($event, $msg);
		//		});
	}

	public function muliLineMsg($event, $msg)
	{
		$messages = explode("\n", $msg);

		foreach($messages as $message)
		{
			$event->addResponse(Response::msg(
				$event->getRequest()
				      ->getSource(),
				$message
			));
		}
	}
}