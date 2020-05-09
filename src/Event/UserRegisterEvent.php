<?php
namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * this an event : we will use this event and dispatche it to listener 
 * must to extend from Event
 */
class UserRegisterEvent extends Event
{
    /**
     * when  dispatche an event  we will use this name 
     * this name is unique 
     */
    const Name='user.register';

    private $userRegister;

    public function __construct(User $userRegister)
    {
        $this->userRegister=$userRegister;
    }

    /**
     * Get the value of userRegister
     */ 
    public function getUserRegister()
    {
        return $this->userRegister;
    }
}