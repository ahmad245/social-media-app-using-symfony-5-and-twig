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
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
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