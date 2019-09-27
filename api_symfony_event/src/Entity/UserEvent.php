<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="users_event")
 * @ORM\Entity(repositoryClass="App\Repository\UserEventRepository")
 */
class UsersEvent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @ORM\ManyToOne(targetEntity="Event")
    * @ORM\JoinColumn(nullable=false)
    */
    public $event;

    /**
    * @ORM\ManyToOne(targetEntity="User")
    * @ORM\JoinColumn(nullable=false)
    */
    public $user;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setEvent(Event $event)
    {
        $this->event = $event;

        return $this;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }
}

