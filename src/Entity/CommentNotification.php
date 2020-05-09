<?php

namespace App\Entity;

use App\Entity\Notification;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentNotificationRepository")
 */
class CommentNotification extends Notification
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment")
     *  @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $comment;


   /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
      *  @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $commentedBy;

      /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post")
     *  @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $post;
    
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
     * Get the value of post
     */ 
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of post
     *
     * @return  self
     */ 
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get the value of likedBy
     */ 
    public function getCommentedBy()
    {
        return $this->commentedBy;
    }

    /**
     * Set the value of likedBy
     *
     * @return  self
     */ 
    public function setCommentedBy($commentedBy)
    {
        $this->commentedBy = $commentedBy;

        return $this;
    }
}
