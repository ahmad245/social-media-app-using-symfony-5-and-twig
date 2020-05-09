<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="my_profile")
     */
    public function index(UserRepository $repoUser,PostRepository $repoPost)
    {
         $user=$this->getUser();
        return $this->render('profile/index.html.twig', [
           'user'=>$user
        ]);
    }

    /**
     * @Route("/profile/myPost", name="my_profile_posts")
     */
    public function myPost(UserRepository $repoUser,PostRepository $repoPost)
    {
         $posts=$repoPost->findMyPost($this->getUser());
        return $this->render('profile/myPost.html.twig', [
           'posts'=>$posts
        ]);
    }
    /**
     * @Route("/profile/myLiked", name="my_profile_likes")
     */
    public function myLikes(UserRepository $repoUser,PostRepository $repoPost)
    {
         $posts=$repoPost->findPostsBbLikedByUser($this->getUser());
        return $this->render('profile/myLikes.html.twig', [
           'posts'=>$posts
        ]);
    }

    
    /**
     * @Route("/profile/myCommented", name="my_profile_commented")
     */
    public function myPostCommented(UserRepository $repoUser,PostRepository $repoComment)
    {
         $posts=$repoComment->findPostsWhereCommentedByUser($this->getUser());
        return $this->render('profile/myCommented.html.twig', [
           'posts'=>$posts
        ]);
    }

    /**
     * @Route("/profile/follow/{id}", name="my_profile_follow")
     */
    public function follow($id)
    {
         $user=$this->getUser();
        return $this->render('profile/following_follower.html.twig', [
           'user'=>$user,
           'followers'=> $id == 1 ? false :true,
           'following'=> $id == 1 ? true :false,
        ]);
    }
}
