<?php
/**
 * Created by PhpStorm.
 * User: bzelic
 * Date: 8/19/15
 * Time: 12:39 PM
 */

namespace MyIRCBot\Entities\Attacks;


use MyIRCBot\Entities\User;

class Punch extends BaseAttack implements IAttack
{
	public $strength = 10;

	public function performAttack(User $sending, User $receiving)
	{
		if ($sending->isConfused())
		{
			$this->message .= $this->doDamage($sending, $this);
		} else
		{
			$this->message .= $this->doDamage($receiving, $this);
		}

		return $this->strength;
	}

	public function getDisplay(User $sending, User $receiver)
	{
		$sendingUsername = $sending->getUsername();
		if($sending->isConfused())
		{
			$this->message .=  "$sendingUsername O=('-'Q)=  " . $sendingUsername;
		}
		else
		{
			$this->message .= $receiver->getUsername() ." O=('-'Q)= " .$sendingUsername;
		}

		return $this->message;
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