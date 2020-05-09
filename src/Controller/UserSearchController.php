<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserSearchController extends AbstractController
{
    /**
     * @Route("/user/search/{user}", name="user_search")
     */
    public function index($user,UserRepository $repo)
    {
        return $this->json($repo->searchByIdentity($user),200,[],['groups'=>['user']]);
    }
}
