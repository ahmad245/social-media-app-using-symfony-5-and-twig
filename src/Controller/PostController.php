<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Tag;
use App\Entity\Post;
use App\Entity\Search;
use App\Entity\User;
use App\Form\PostType;
use App\Form\SearchType;
use App\Repository\TagRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
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
  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }
  /**
   * @Route("/",name="home")
   * @Route("/post", name="post")
   */
  public function index(PostRepository $repo, UserRepository $userRepo, Request $req)
  {
    $usersToFollow = [];
    $search = new Search();
    $form = $this->createForm(SearchType::class, $search);
    $form->handleRequest($req);
    if ($form->isSubmitted() && $form->isValid()) {
      $posts = $repo->fillter($search);
    } else {

      if ($this->getUser() instanceof User) {
        $posts = $repo->findByUsers($this->getUser()->getFollowing());

        $usersToFollow = count($posts) === 0 ? $userRepo->findByMoreThan5Post($this->getUser()) : [];
      } else {
        $posts = $repo->findAllPost();
      }
    }

    return $this->render('post/index.html.twig', [
      'posts' => $posts,
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
  public function show($id, PostRepository $repo)
  {
    $post = $repo->findByPost($id);
    return $this->render('post/show.html.twig', [
      'post' => $post,
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
    // $posts=$user->getPosts(); // but can not sorted 
    // $posts = $repo->findBy(['user' => $user], ['createAt' => 'DESC']);
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
  public function myPost(User $user, PostRepository $repo)
  {
    // $posts=$user->getPosts(); // but can not sorted 

    $posts = $repo->findMyPost($user);
    // $posts = $repo->findBy(['user' => $user], ['createAt' => 'DESC']);

    return $this->render('post/myPosts.html.twig', [
      'posts' => $posts
    ]);
  }


  /**
   * @Route("/post/tag/{id}",name="post_tag")
   *
   * @param User $user
   * @param PostRepository $repo
   * @return void
   */
  public function tagPost(Tag $tag, PostRepository $repo)
  {
    // $posts=$tag->getPosts();

    $posts = $repo->findByTags($tag->getId());

    return $this->render('post/post_tag.html.twig', [
      'posts' => $posts,
    ]);
  }
}
