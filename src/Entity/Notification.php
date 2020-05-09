<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 *  @ORM\DiscriminatorMap({"like" = "LikeNotification", "following" = "FollowingNotification","comment"="CommentNotification"})
 */
abstract class Notification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     *  @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $seen;

    public function __construct()
    {
        $this->seen = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of seen
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * Set the value of seen
     *
     * @return  self
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
