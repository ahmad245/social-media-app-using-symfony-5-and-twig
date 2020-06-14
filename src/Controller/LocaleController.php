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
       // $req->getSession()->get('_locale', $id);
       //$this->session->set('_local',$id);
       
      
       $req->getSession()->set('_locale',$id);
        $req->setLocale($id);
        $referer = $req->headers->get('referer');
       return $this->redirect( $referer);
      
    //    dd( $referer);die;
       // return new RedirectResponse($referer);
        // dump($req->getLocale());

      // return  $this->redirectToRoute('home');
        // return $this->json($req->getLocale(),200,[]);
       // return $this->redirectToRoute('home');
       
      
        // return $this->render('locale/index.html.twig', [
        //     'controller_name' => 'LocaleController',
        // ]);
    }
}
