<?php
/**
 * Created by PhpStorm.
 * User: bzelic
 * Date: 8/19/15
 * Time: 12:50 PM
 */

namespace MyIRCBot\Entities\Attacks;


use MyIRCBot\Entities\User;

class Flip extends BaseAttack implements IAttack
{
	public $strength = 10;

	public function performAttack(User $sending, User $receiving)
	{
		return $this->strength;
	}

	public function getDisplay(User $sending, User $receiver)
	{
		$sendingUsername = $sending->getUsername();
		if ($sending->isConfused())
		{
			$msg = "$sendingUsername (╯ಥ益ಥ）╯﻿︵  " . $sendingUsername;

		} else {

			$msg = "$sendingUsername (╯ಥ益ಥ）╯﻿︵ " .  $receiver->getUsername();
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