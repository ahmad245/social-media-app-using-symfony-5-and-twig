<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CommentController extends AbstractController
{
    private $em;
  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }
    /**
     * @Route("/comment/{id}", name="comment_add")
     *  @Security("is_granted('ROLE_USER') ")
     */
    public function add(Post $post, Request $req)
    {
       
        $comment=new Comment();

       
        
        $form=$this->createForm(CommentType::class,$comment);
        $form->handleRequest($req);
     
        if($form->isSubmitted() && $form->isValid())
        {
          
           $comment->setUser($this->getUser());
          $comment->setPost($post);
          $this->em->persist($comment);
          $this->em->flush();
        
         
          return $this->redirectToRoute('post_show',['id'=>$post->getId()]);
        }

      
        return $this->render('comment/index.html.twig', [
            'form' => $form->createView(),
            'id'=>$post->getId(),
            'path'=>'comment_add',
         
        ]);
    }
    /**
     * @Route("/comment/{id}/edit", name="comment_edit")
     * @Security("is_granted('ROLE_EDITER') or  (is_granted('ROLE_USER') and user==comment.getUser())")
     */
    public function edit(Comment $comment, Request $req)
    {
       $postId=$comment->getPost()->getId();
        $form=$this->createForm(CommentType::class,$comment);
        $form->handleRequest($req);
     
        if($form->isSubmitted() && $form->isValid())
        {
   
          $this->em->flush();
          return $this->redirectToRoute('post_show',['id'=>$postId]);
        }
        return $this->render('comment/index.html.twig', [
            'form' => $form->createView(),
            'id'=>$comment->getId(),
            'path'=>'comment_edit'
        ]);
    }

    /**
     * @Route("/comment/{id}/delete", name="comment_delete")
     *  @Security("is_granted('ROLE_EDITER') or  (is_granted('ROLE_USER') and user==comment.getUser())")
     */
    public function delete(Comment $comment){
      $postId=$comment->getPost()->getId();
       $this->em->remove($comment);
       $this->em->flush();
       return $this->redirectToRoute('post_show',['id'=>$postId]);

    }

    /**
     * @Route("/comment/post/{id}", name="comments_post")
     */
    public function commentsForPost(Post $post,CommentRepository $repo,Request $req){
      $page=2;
      if ($req->query->get('page')) {
       $page = $req->query->get('page');
    }
      $limit=5;
      $total=0;
      $offset= ($page * $limit) -$limit ;
      $data=$repo->findByPost($post->getId(),$limit,$offset);

      $result= $this->render('comment/comments.html.twig', [
        'post' => $post,
        'comments'=> $data
      ]);
      return $this->json($result->getContent(),200,[]);
    }

    
}
