<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin/login", name="admin_account_login")
     */
    public function login(AuthenticationUtils $util)
    {
        $error = $util->getLastAuthenticationError();

        return $this->render('admin/account/login.html.twig', ['error' => $error]);
    }

    /**
     * @Route("/admin/logout",name="admin_account_logout")
     *
     * @return void
     */
    public function logout(){

    }
}
