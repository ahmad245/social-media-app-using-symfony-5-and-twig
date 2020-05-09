<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 *@Security("is_granted('ROLE_USER')")
 */
class FollowingController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    /**
     * @Route("/following/{id}", name="following")
     */
    public function following(User $user)
    {
       $this->getUser()->addFollowing($user);
       $this->em->flush();
      return  $this->redirectToRoute('post_user',['id'=>$user->getId()]);

    }
    /**
     * @Route("/unfollowing/{id}", name="unfollowing")
     */
    public function unFollowing(User $user)
    {
        $this->getUser()->removeFollowing($user);
       $this->em->flush();
      return  $this->redirectToRoute('post_user',['id'=>$user->getId()]);
    }
}
