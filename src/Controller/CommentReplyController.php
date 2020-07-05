<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\CommentReply;
use App\Entity\Post;
use App\Form\CommentReplyType;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CommentReplyController extends AbstractController
{
  private $em;
  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }
  /**
   * @Route("/comment/reply/{id}/{postId}", name="comment_reply")
   * @ParamConverter("comment", options={"exclude": {"postId"}})
   * @Security("is_granted('ROLE_USER') ")
   */
  public function add(Comment $comment, $postId, Request $req)
  {

    $replyComment = new CommentReply();

    $form = $this->createForm(CommentReplyType::class, $replyComment);
    $form->handleRequest($req);

    if ($form->isSubmitted() && $form->isValid()) {
      $replyComment->setUser($this->getUser());
      $replyComment->setComment($comment);
      $this->em->persist($replyComment);
      $this->em->flush();
      return $this->redirectToRoute('post_show', ['id' => $postId]);
    }
    return $this->render('comment_reply/index.html.twig', [
      'form' => $form->createView(),
      'id' => $comment->getId(),
      'postId' => $postId,
      'path' => 'comment_reply'
    ]);
  }



  /**
   * @Route("/comment/reply/{id}/{postId}/edit", name="comment_reply_edit")
   *  @ParamConverter("replyComment", options={"exclude": {"postId"}})
   * @Security("is_granted('ROLE_EDITER') or  (is_granted('ROLE_USER') and user==replyComment.getUser())")
   */
  public function edit(CommentReply $replyComment, $postId, Request $req)
  {

    $form = $this->createForm(CommentReplyType::class, $replyComment);
    $form->handleRequest($req);

    if ($form->isSubmitted() && $form->isValid()) {

      $this->em->flush();
      return $this->redirectToRoute('post_show', ['id' => $postId]);
    }
    return $this->render('comment_reply/index.html.twig', [
      'form' => $form->createView(),
      'id' => $replyComment->getId(),
      'postId' => $postId,
      'path' => 'comment_reply_edit'
    ]);
  }

  /**
   * @Route("/comment/reply/{id}/{postId}/delete", name="comment_reply_delete")
   * @ParamConverter("replyComment", options={"exclude": {"postId"}})
   * @Security("is_granted('ROLE_EDITER') or  (is_granted('ROLE_USER') and user==replyComment.getUser())")
   */
  public function delete(CommentReply $replyComment, $postId)
  {

    $this->em->remove($replyComment);
    $this->em->flush();
    return $this->redirectToRoute('post_show', ['id' => $postId]);
  }
}
