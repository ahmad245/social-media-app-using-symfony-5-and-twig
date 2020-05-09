<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



class ForgottenPassword
{
  /**
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(
     *  min=3,
     *  max=255,
     * minMessage="Your Last Name  must be at least {{ limit }} characters long",
     * maxMessage="Your Last Name  cannot be longer than {{ limit }} characters"
     * )
     *
     */
    private $email;


    /**
     * Get min=3,
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set min=3,
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}
