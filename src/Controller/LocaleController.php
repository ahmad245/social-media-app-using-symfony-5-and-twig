<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocaleController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    /**
     * @Route("/locale/{id}", name="locale")
     */
    public function index($id,Request $req)
    {
      
       $req->getSession()->set('_locale',$id);
        $req->setLocale($id);
        $referer = $req->headers->get('referer');
       return $this->redirect( $referer);
      
   
    }
}
