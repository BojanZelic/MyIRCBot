<?php

namespace MyIRCBot\Entities;

use Doctrine\ORM\Mapping as ORM;
use Philip\IRC\Request;

/**
 * User
 *
 * @ORM\Table(name="User")
 * @ORM\Entity
 */
class User
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
     * @ORM\Column(name="ip_address", type="string", length=45, nullable=true)
     */
    private $ipAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=45, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="MaxHP", type="decimal", precision=2, scale=0, nullable=true)
     */
    private $maxhp;

    /**
     * @var string
     *
     * @ORM\Column(name="HP", type="decimal", precision=2, scale=0, nullable=true)
     */
    private $hp;

    /**
     * @var string
     *
     * @ORM\Column(name="Level", type="decimal", precision=2, scale=0, nullable=true)
     */
    private $level;

    public function __construct()
    {
        $this->hp = 40;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getipAddress()
    {
        return $this->ipAddress;
    }

    public function getHP()
    {
        return $this->hp;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function doDamage($damage)
    {
        if ($this->hp > 0)
        {
            $this->hp -= floor($damage);
        }

        if ($this->hp < 0)
        {
            $this->hp = 0;
        }

        return $damage;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getMaxHP()
    {
        return $this->maxhp;
    }

    public function updateFromRequest(Request $request)
    {
        $this->ipAddress    = $request->getHost();
        $this->username     = $request->getSendingUser();
        if (!$this->getLevel()) {
            $this->level = 1;
        }
    }

    public function __toString()
    {
        return
          "Level: " . $this->getLevel() . "\n" .
          "HP: " . $this->getHP() . "/" . $this->getMaxHP() . "\n";
    }

}

