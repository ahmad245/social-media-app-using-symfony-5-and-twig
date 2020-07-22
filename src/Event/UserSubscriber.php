<?php
namespace App\Event;

use App\Mailer\Mailer;
use App\Event\UserRegisterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private $mailer;
    public function __construct( Mailer $mailer)
    {
        $this->mailer=$mailer;  
    }
     /**
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents(){

        // it is can listen one or more event 
        //name of event and the method we should execute when this event trigger
        return [
            UserRegisterEvent::Name=>'onRegister',
            UserResetPasswordEvent::Name=>'onResetPassword'
        ];
    }

    public function onRegister(UserRegisterEvent $event)
    {
        
        $this->mailer->sendConfirmation($event->getUserRegister());
    }

    public function onResetPassword(UserResetPasswordEvent $event)
    {
        
        $this->mailer->sendConfirmationResetPassword($event->getUserRegister());
    }
}