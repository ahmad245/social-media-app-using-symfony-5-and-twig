<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ResetPassword
{
    /**
      * @Assert\Regex(
     *   pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}/",
     *   message="Password must be seven charachters and contain at least one digit,one uppercase and one lowercase"
     * )
     */
   
    private $newPassword;

    /**
     * Get the value of newPassword
     */ 
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * Set the value of newPassword
     *
     * @return  self
     */ 
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;

        return $this;
    }
}
