<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\SettingType;
use App\Event\UserRegisterEvent;
use App\Form\UpdatePasswordType;
use App\Security\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use App\Security\UserConfirmationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    private $em;
    private $eventDispatcher;
    private $userConfirmationService;
    private $tokenGenerator;
    public function __construct(
        EntityManagerInterface $em,
        EventDispatcherInterface $eventDispatcher,
        UserConfirmationService $userConfirmationService,
        TokenGenerator $tokenGenerator
        ) {
        $this->em = $em;
        $this->eventDispatcher=$eventDispatcher;
        $this->userConfirmationService=$userConfirmationService;
        $this->tokenGenerator=$tokenGenerator;
    }
    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $util)
    {
        $error = $util->getLastAuthenticationError();

        return $this->render('account/login.html.twig',['error' => $error]);
    }

    /**
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout(){

    }

    /**
     * @Route("/register",name="account_register")
     */

    public function register(Request $req,UserPasswordEncoderInterface $encode){
        $user=new User();
        $form=$this->createForm(AccountType::class,$user);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid() ) {
            
           $user->setPassword($encode->encodePassword($user,$user->getPassword()));
           $user->setConfirmationToken($this->tokenGenerator->getRandomSecureToken());
            $this->em->persist($user);
            $this->em->flush();
            
            //create instance from event and pass user as information 
            $userRegisterEvent=new UserRegisterEvent($user);

            //dispatch the event using EventDispatcherInterface method dispatch(event object ,event name); 
            $this->eventDispatcher->dispatch($userRegisterEvent,UserRegisterEvent::Name); 

            return $this->redirectToRoute('account_login');
        }
        return $this->render('account/register.html.twig',[
            'form'=>$form->createView()
        ]);
    }

     /**
     * @Route("/confirm-user/{token}", name="default_confirm_token")
     */
    public function confirmUser(string $token){

        $this->userConfirmationService->confirmUser($token);
        return $this->redirectToRoute('account_login');
    }

    
   /**
     * @Route("/edit/{id}",name="account_edit")
     */
    public function edit(User $user,Request $req)
    {
        $form=$this->createForm(SettingType::class,$user);
        $form->handleRequest($req);
        if ($form->isSubmitted()  ) {
          dd( $form->getData()->getCity());die;
            $this->em->flush();
            return $this->redirectToRoute('account_login');
        }
        return $this->render('account/edit.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    
}
