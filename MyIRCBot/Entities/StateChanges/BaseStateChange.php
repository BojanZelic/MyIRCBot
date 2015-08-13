<?php
/**
 * Created by PhpStorm.
 * User: bzelic
 * Date: 8/13/15
 * Time: 11:44 AM
 */

namespace MyIRCBot\Entities\StateChange;

interface BaseStateChange
{
	public function performStateChange();
}