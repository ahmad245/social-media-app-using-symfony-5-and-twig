<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Search;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Services\PaginationService;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProfileController extends AbstractController
{
  
  private $pagination;
  public function __construct(PaginationService $pagination)
  {
   
    $this->pagination = $pagination;
  }
    /**
     * @Route("/profile/{id}", name="my_profile")
     */
    public function index(User $user,UserRepository $repoUser,PostRepository $repoPost)
    {
        
        return $this->render('profile/index.html.twig', [
           'user'=>$user
        ]);
    }

    /**
     * @Route("/profile/myPost/{id}", name="my_profile_posts")
     */
    public function myPost(User $user,UserRepository $repoUser,PostRepository $repoPost,Request $req)
    {
      $search = new Search();
     
      if ($req->query->get('page')) {
        $search->page = $req->query->get('page');
       
        
    }
    
    $limit=5;
    $data = [];
    $total=0;
    $offset= ($search->page * $limit) -$limit ;
       $data= $repoPost->findMyPost($user,$limit, $offset);
      $this->pagination->setEntityClass(Post::class)
                        ->setData($data)->setLimit($limit)
                        ->setPage($search->page)
                        ->setTotal($data->count());
        $result= $this->render('profile/myPost.html.twig', [
           'posts'=> $this->pagination,
           'pages'=>  $this->pagination->getPages(),
           'page'=>  $this->pagination->getPage()
        ]);
        $dataJson=['templete'=>$result,'page'=> $search->page];
        return $this->json($dataJson,200,[]);

    }
    /**
     * @Route("/profile/myLiked/{id}", name="my_profile_likes")
     */
    public function myLikes(User $user,UserRepository $repoUser,PostRepository $repoPost,Request $req)
    {
      $search = new Search();
     
      if ($req->query->get('page')) {
        $search->page = $req->query->get('page');
    }
         $limit=5;
         $data = [];
         $total=0;
         $offset= ($search->page * $limit) -$limit ;
         $data=$repoPost->findPostsBbLikedByUser($user,$limit, $offset);
         $this->pagination->setEntityClass(Post::class)
                  ->setData($data)->setLimit($limit)
                  ->setPage($search->page)
                  ->setTotal($data->count());
       $result=  $this->render('profile/myLikes.html.twig', [
           'posts'=> $this->pagination,
           'pages'=>  $this->pagination->getPages(),
           'page'=>  $this->pagination->getPage()
          
        ]);
        $dataJson=['templete'=>$result,'page'=> $search->page];
        return $this->json($dataJson,200,[]);
    }

    
    /**
     * @Route("/profile/myCommented/{id}", name="my_profile_commented")
     */
    public function myPostCommented(User $user,UserRepository $repoUser,PostRepository $repoComment,Request $req)
    {
      $search = new Search();
     
      if ($req->query->get('page')) {
        $search->page = $req->query->get('page');
    }
      
      $limit=5;
      $data = [];
      $total=0;
      $offset= ($search->page * $limit) -$limit ;
      $data=$repoComment->findPostsWhereCommentedByUser($user,$limit, $offset);
      $this->pagination->setEntityClass(Post::class)
               ->setData($data)->setLimit($limit)
               ->setPage($search->page)
               ->setTotal($data->count());
    $result=  $this->render('profile/myCommented.html.twig', [
        'posts'=> $this->pagination,
        'pages'=>  $this->pagination->getPages(),
        'page'=>  $this->pagination->getPage()
       
     ]);
     $dataJson=['templete'=>$result,'page'=> $search->page];
     return $this->json($dataJson,200,[]);
        
    }

    /**
     * @Route("/profile/{userId}/follow/{id}", name="my_profile_follow")
     */
    public function follow(User $userId,$id)
    {
         // $user=$this->getUser();
        return $this->render('profile/following_follower.html.twig', [
           'user'=>$userId,
           'followers'=> $id == 1 ? false :true,
           'following'=> $id == 1 ? true :false,
        ]);
    }
}
