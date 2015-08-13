<?php
/**
 * Created by PhpStorm.
 * User: bzelic
 * Date: 8/13/15
 * Time: 11:44 AM
 */

namespace MyIRCBot\Entities\Attacks;

use MyIRCBot\Entities\User;

interface IAttack
{
	public function performAttack(User $sending, User $receiving);

	public function getDisplay(User $sending, User $catching);

	public function getStrength();

	public function getMissedChance();

	public function getCriticalHit();
}