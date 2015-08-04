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

    private $state;

    private $isMinion = false;

    public function __construct()
    {
        $this->hp = 40;
        $this->maxhp = 40;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($value)
    {
        $this->username = $value;
    }

    public function addState(State $state)
    {
        $this->state[] = $state;
    }

    public function isConfused()
    {
        if (isset($this->state))
        {
            foreach ($this->state as $state)
            {
                if ($state === STATE::CONFUSED)
                {
                    return true;
                }
            }
        }

        return false;
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
        $damage = min($this->hp, $damage);

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

    private function setIsMinion($value)
    {
        $this->isMinion = $value;
    }

    public function getIsMinion()
    {
        return $this->isMinion;
    }

    public function updateFromRequest(Request $request)
    {
        $this->ipAddress    = $request->getHost();
        $this->username     = $request->getSendingUser();

        //depending on how different a Minion becomes from a user.
        // I may consider creating a UserFactory that creates Users/Minions
        if (stripos($this->username, 'Minion') !== false){
            $this->setIsMinion(true);
        }
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

