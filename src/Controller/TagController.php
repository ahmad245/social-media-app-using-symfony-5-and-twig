<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
     * @Route("/tag/{text}", name="tag_search")
     */
    public function index($text,TagRepository $repo)
    {
        return $this->json($repo->search($text),200,[],['groups'=>['tag']]);
    }
    
    
}
