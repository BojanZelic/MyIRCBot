<?php
/**
 * Created by PhpStorm.
 * User: bzelic
 * Date: 8/3/15
 * Time: 9:20 PM
 */

namespace MyIRCBot\Entities;

class State
{
	CONST CONFUSED = "Confused";

	private $id;

	private $state;

	public function __construct($state)
	{
		$this->state = $state;
	}

	public function getID()
	{
		return $this->id;
	}

	public function setState($state)
	{
		$this->state = $state;
	}

	public function getState()
	{
		return $this->state;
	}

}