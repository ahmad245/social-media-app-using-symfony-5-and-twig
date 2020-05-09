<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CommentController extends AbstractController
{
    private $em;
  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }
    /**
     * @Route("/comment/{id}", name="comment_add")
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
          return $this->redirectToRoute('home');
        }
        return $this->render('comment/index.html.twig', [
            'form' => $form->createView(),
            'id'=>$post->getId(),
            'path'=>'comment_add'
        ]);
    }
    /**
     * @Route("/comment/{id}/edit", name="comment_edit")
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
     */
    public function delete(Comment $comment){
      $postId=$comment->getPost()->getId();
       $this->em->remove($comment);
       $this->em->flush();
       return $this->redirectToRoute('post_show',['id'=>$postId]);

    }

    
}
