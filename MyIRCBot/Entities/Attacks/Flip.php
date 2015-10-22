<?php
/**
 * Created by PhpStorm.
 * User: bzelic
 * Date: 8/19/15
 * Time: 12:50 PM
 */

namespace MyIRCBot\Entities\Attacks;


use MyIRCBot\Entities\User;
use MyIRCBot\Utilities\StringTools;

class Flip extends BaseAttack implements IAttack
{
	public $strength = 10;

	public function performAttack(User $sending, User $receiving)
	{
		return $this->strength;
	}

	public function getDisplay(User $sending, User $receiver)
	{
		$sendingUsername = StringTools::flip($sending->getUsername());
		$receiverUsername = StringTools::flip($receiver->getUsername());
		if ($sending->isConfused())
		{
			$msg = "(╯ಥ益ಥ）╯﻿︵  " . $sendingUsername;

		} else {

			$msg = "(╯ಥ益ಥ）╯﻿︵ " .  $receiverUsername;
		}

		return $msg;
	}

	public function getStrength()
	{
		return 10;
	}

	public function getMissedChance()
	{
		return 10;
	}

	public function getCriticalHit()
	{
		return 10;
	}
}