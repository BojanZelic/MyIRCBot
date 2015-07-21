<?php

namespace MyIRCBot\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attacks
 *
 * @ORM\Table(name="Attacks")
 * @ORM\Entity
 */
class Attacks
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="Name", type="string", length=45, nullable=true)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="Strength", type="decimal", precision=5, scale=0, nullable=true)
	 */
	private $strength;

}

