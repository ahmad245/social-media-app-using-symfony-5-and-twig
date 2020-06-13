<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Search;
use App\Form\PostType;
use App\Form\SearchType;
use App\Repository\CommentRepository;
use App\Repository\TagRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Services\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\LikeNotificationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
  private $em;
  private $pagination;
  public function __construct(EntityManagerInterface $em,PaginationService $pagination)
  {
    $this->em = $em;
    $this->pagination = $pagination;
  }
  /**
   * @Route("/",name="home")
   * @Route("/post", name="post")
   */
  public function index(PostRepository $repo, UserRepository $userRepo, Request $req)
  {
   
    $search = new Search();
    
    if ($req->query->get('page')) {
      $search->page = $req->query->get('page');
  }
  $limit=5;
  $usersToFollow = [];
  $data = [];
  $total=0;
  $offset= ($search->page * $limit) -$limit ;
    $form = $this->createForm(SearchType::class, $search);
    $form->handleRequest($req);
    if ($form->isSubmitted() && $form->isValid()) {
      // $posts = $repo->fillter($search);
      $data=$repo->fillter($search,$limit, $offset);
      // $total=$data->count();
    } 
    else{

      if ($this->getUser() instanceof User) {
       // $posts = $repo->findByUsers($this->getUser()->getFollowing());
        $data=$repo->findByUsers($this->getUser()->getFollowing(),$limit, $offset);
        // $total=$data->count();

        $usersToFollow = $data->count() === 0 ? $userRepo->findByMoreThan5Post($this->getUser()) : [];
      } else {
       // $posts = $repo->findAllPost();
       $data=$repo->findAllPost($limit, $offset);
      //  $total=$data->count();
       
      }
    }
     $this->pagination->setEntityClass(Post::class)->setData($data)->setLimit($limit)->setPage($search->page)->setTotal($data->count());
    return $this->render('post/index.html.twig', [
      'posts' => $this->pagination,
      'usersToFollow' => $usersToFollow,
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/post/add", name="post_add")
   * @Security("is_granted('ROLE_USER') ")
   *
   * @param Request $req
   * @return void
   */
  public function add(Request $req, TagRepository $tagRepo)
  {
    $post = new Post();

    $form = $this->createForm(PostType::class, $post);
    $form->handleRequest($req);


    if ($form->isSubmitted() && $form->isValid()) {


      // dump( $form->getData(),$post->getTags());die;
      foreach ($post->getTags() as $tag) {
        $tagExest = $tagRepo->findOneBy(['name' => $tag->getName()]);

        if ($tagExest) {
          $post->getTags()->removeElement($tag);
          $post->addTag($tagExest);
        } else {

          $this->em->persist($tag);
          $post->addTag($tag);
          $tag->addPost($post);
        }
      }
      foreach ($post->getImages() as $image) {

     
        $image->setPost($post);
        $this->em->persist($image);
      }
      $post->setUser($this->getUser());

      $this->em->persist($post);

      $this->em->flush();

      return $this->redirectToRoute('home');
    }
    return $this->render('post/create.html.twig', [
      'form' => $form->createView()
    ]);
  }


  /**
   * @Route("/post/edit/{id}",name="post_edit")
   * @Security("is_granted('ROLE_EDITER') or  (is_granted('ROLE_USER') and user==post.getUser())")
   * @param Post $post
   * @param Request $req
   * @return void
   */
  public function edit(Post $post, Request $req, TagRepository $tagRepo)
  {

    $form = $this->createForm(PostType::class, $post);
    $form->handleRequest($req);
    if ($form->isSubmitted()) {
     
      foreach ($post->getImages() as $image) {
        $image->setPost($post);
        $this->em->persist($image);
      }
      foreach ($post->getTags() as $tag) {
        $tagExest = $tagRepo->findOneBy(['name' => $tag->getName()]);

        if ($tagExest) {

          $post->getTags()->removeElement($tag);
          $post->addTag($tagExest);
        } else {

          $this->em->persist($tag);
          $post->addTag($tag);
          $tag->addPost($post);
        }
      }

      $this->em->flush();

      return $this->redirectToRoute('home');
    }
    return $this->render('post/create.html.twig', [
      'form' => $form->createView(),
      'method' => 'edit'
    ]);
  }

  /**
   * @Route("/post/delete/{id}",name="post_delete")
   * @Security("is_granted('ROLE_EDITER') or  (is_granted('ROLE_USER') and user==post.getUser())")
   * @param Post $post
   * @return void
   */
  public function delete(Post $post, LikeNotificationRepository $repoNotification)
  {
    $notifications = $repoNotification->findBy(['post' => $post]);


    // dump($notifications,$post);die;
    $this->em->remove($post);
    if (count($notifications) > 0) {
      foreach ($notifications as $notification) {
        $this->em->remove($notification);
      }
    }

    $this->em->flush();
    $this->addFlash('success', 'the post was deleted');
    return $this->redirectToRoute('home');
  }


  /**
   * @Route("/post/{id}",name="post_show")
   *
   * @param Post $post
   * @return void
   */
  public function show($id, PostRepository $repo,CommentRepository $commentRepo)
  {
    $page=1;
    
    $limit=5;
    $total=0;
    $offset= ($page * $limit) -$limit ;
    
    $post = $repo->findByPost($id);
    $comments=$commentRepo->findByPost($id,$limit,$offset);
    return $this->render('post/show.html.twig', [
      'post' => $post,
      'comments'=> $comments
    ]);
  }

  /**
   * @Route("/post/user/{id}",name="post_user")
   *
   * @param User $user
   * @param PostRepository $repo
   * @return void
   */
  public function userPost(User $user, PostRepository $repo)
  {
  
    $posts = $repo->findByUser($user);

    return $this->render('post/post_user.html.twig', [
      'posts' => $posts,
      'user' => $user
    ]);
  }

  /**
   * @Route("/post/myPost/{id}",name="my_posts")
   *
   * @param User $user
   * @param PostRepository $repo
   * @return void
   */
  public function myPost(User $user, PostRepository $repo,Request $req)
  {
    $search = new Search();
    
    if ($req->query->get('page')) {
      $search->page = $req->query->get('page');
  }
  $limit=5;
  $usersToFollow = [];
  $data = [];
  $total=0;
  $offset= ($search->page * $limit) -$limit ;
    $form = $this->createForm(SearchType::class, $search);
    $form->handleRequest($req);
    if ($form->isSubmitted() && $form->isValid()) {
      // $posts = $repo->fillter($search);
      $data=$repo->fillter($search,$limit, $offset);
      // $total=$data->count();
    } 
    else{
     $data= $repo->findMyPost($user,$limit, $offset);
    }
 

    $this->pagination->setEntityClass(Post::class)->setData($data)->setLimit($limit)->setPage($search->page)->setTotal($data->count());

    return $this->render('post/index.html.twig', [
      'posts' =>  $this->pagination,
      'form' => $form->createView()
    ]);
  }


  /**
   * @Route("/post/tag/{id}",name="post_tag")
   *
   * @param User $user
   * @param PostRepository $repo
   * @return void
   */
  public function tagPost(Tag $tag, PostRepository $repo,Request $req)
  {
   
    $search = new Search();
    
    if ($req->query->get('page')) {
      $search->page = $req->query->get('page');
  }
  $limit=5;
  $usersToFollow = [];
  $data = [];
  $total=0;
  $offset= ($search->page * $limit) -$limit ;
    $form = $this->createForm(SearchType::class, $search);
    $form->handleRequest($req);
    if ($form->isSubmitted() && $form->isValid()) {
      // $posts = $repo->fillter($search);
      $data=$repo->fillter($search,$limit, $offset);
      // $total=$data->count();
    } 
    else{
     $data= $repo->findByTags($tag->getId(),$limit, $offset);
    }
    // $posts=$tag->getPosts();

    $this->pagination->setEntityClass(Post::class)->setData($data)->setLimit($limit)->setPage($search->page)->setTotal($data->count());

    return $this->render('post/index.html.twig', [
      'posts' => $this->pagination,
      'form' => $form->createView()
    ]);
  }
}
