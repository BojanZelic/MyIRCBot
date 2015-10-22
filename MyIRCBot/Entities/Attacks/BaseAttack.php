<?php
/**
 * Created by PhpStorm.
 * User: bzelic
 * Date: 8/13/15
 * Time: 11:57 AM
 */

namespace MyIRCBot\Entities\Attacks;

use MyIRCBot\Entities\User;

abstract class BaseAttack
{
	protected $message = "";

	public function doDamage(User &$user, IAttack $attack)
	{
		$username = $user->getUsername();

		$maxHP = $user->getMaxHP();
		$damage = $user->doDamage(rand(0,40));
		$newHP = $user->getHP();

		$msg = "\n $username took $damage Damage. HP:$newHP/$maxHP \n";

		if ($newHP == 0) {
			$msg = "\n $username is KO'd \n";
		}

		return $msg;
	}
}