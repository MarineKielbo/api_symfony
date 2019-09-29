<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserEventRepository")
 */
class UserEvent
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
     * @ORM\ManyToOne(targetEntity="Event", cascade={"persist"})
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="UserInscription", cascade={"persist"})
     */
    private $user_inscription;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    public function getEventId()
    {
        return $this->event;
    }

    public function setEvent(Event $event)
    {
        $this->event = $event;

        return $this;
    }

    public function getUserInscription()
    {
        return $this->user_inscription;
    }

    public function setUserInscription(UserInscription $user_inscription)
    {
        $this->user_inscription = $user_inscription;

        return $this;
    }
}

