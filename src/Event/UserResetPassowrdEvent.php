<?php
namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserResetPasswordEvent extends Event
{
    const Name='user.resetPassword';

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