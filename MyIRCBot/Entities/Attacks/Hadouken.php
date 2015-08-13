<?php
/**
 * Created by PhpStorm.
 * User: bzelic
 * Date: 8/13/15
 * Time: 11:48 AM
 */

namespace MyIRCBot\Entities\Attacks;

use MyIRCBot\Entities\User;

class Hadouken extends BaseAttack implements IAttack
{
	public $strength = 10;

	public function performAttack(User $sending, User $receiving)
	{
		if ($sending->isConfused())
		{
			$this->doDamage($sending, $this);
		} else
		{
			$this->doDamage($receiving, $this);
		}

		return $this->strength;
	}

	public function getDisplay(User $sending, User $receiver)
	{
		$sendingUsername = $sending->getUsername();
		if ($sending->isConfused())
		{
			$msg = "$sendingUsername ༼つಠ益ಠ༽つ ─=≡ΣO)) " . $sendingUsername;

		} else {

			$msg = "$sendingUsername ༼つಠ益ಠ༽つ ─=≡ΣO)) " .  $receiver->getUsername();
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