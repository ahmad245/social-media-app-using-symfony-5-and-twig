<?php

namespace App\Entity;

use App\Entity\Notification;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FollowingNotificationRepository")
 */
class FollowingNotification extends Notification
{
       /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     *  @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
   private $following;

   /**
    * Get the value of following
    */ 
   public function getFollowing()
   {
      return $this->following;
   }

   /**
    * Set the value of following
    *
    * @return  self
    */ 
   public function setFollowing($following)
   {
      $this->following = $following;

      return $this;
   }
}
