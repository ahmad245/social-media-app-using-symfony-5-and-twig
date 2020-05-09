<?php

namespace App\Entity;

use App\Entity\Notification;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikeNotificationRepository")
 */
class LikeNotification extends Notification
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post")
     *  @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $post;


   /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
      *  @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $likedBy;

    /**
     * Get the value of post
     */ 
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set the value of post
     *
     * @return  self
     */ 
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get the value of likedBy
     */ 
    public function getLikedBy()
    {
        return $this->likedBy;
    }

    /**
     * Set the value of likedBy
     *
     * @return  self
     */ 
    public function setLikedBy($likedBy)
    {
        $this->likedBy = $likedBy;

        return $this;
    }
}
