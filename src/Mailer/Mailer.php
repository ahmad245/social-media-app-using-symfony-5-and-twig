<?php
namespace App\Mailer;

use App\Entity\User;
use Swift_Message;

class Mailer{
   private $twig;
   private $mailer;
    public function __construct(\Swift_Mailer $mailer,\Twig\Environment $twig)
    {
        $this->twig=$twig;
        $this->mailer=$mailer;
    }
    public function sendConfirmation(User $user)
    {
        $body=$this->twig->render('Mailer/Mailer.html.twig',[
            'user'=>$user
        ]);

       
        $message = (new \Swift_Message('Please confirm your account!'))
            ->setFrom('basimahagothman123@gmail.com')
            ->setTo($user->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
                
    }

    public function sendConfirmationResetPassword(User $user)
    {
        $body=$this->twig->render('Mailer/MailerResetPassword.html.twig',[
            'user'=>$user
        ]);

       
        $message = (new \Swift_Message('Please confirm your account!'))
            ->setFrom('basimahagothman123@gmail.com')
            ->setTo($user->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
                
    }
}