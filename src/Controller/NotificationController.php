<?php

namespace App\Controller;

use App\Entity\LikeNotification;
use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class NotificationController extends AbstractController
{
    private $repo;
    private $em;
    public function __construct(NotificationRepository $repo,EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }
    /**
     * @Route("/notification", name="notification")
     *  @Security("is_granted('ROLE_USER') ")
     */
    public function unreadCount()
    {
        return $this->json([
            'code' => 200,
            'message' => 'geting',
            'count' => $this->repo->getCountNotification($this->getUser())
        ]);
    }

    /**
    
     * @Route("/notification/all", name="notification_all")
     *  @Security("is_granted('ROLE_USER') ")
     */
    public function allNofification()
    {

        return $this->render('notification/notification.html.twig', [
            'notifications' => $this->repo->findBy(['user' => $this->getUser(), 'seen' => false])
        ]);
    }


    /**
     * @Route("/seen/{id}" , name="mark_seen")
     *  @Security("is_granted('ROLE_USER') ")
     *
     * @param Notification $notification
     * @return void
     */
    public function notificationSeen(Notification $notification)
    {
        $notification->setSeen(true);
        $this->em->flush();

        return $this->redirectToRoute('notification_all');

    }
/**
     * @Route("/allseen" , name="mark_all_seen")
     *  @Security("is_granted('ROLE_USER') ")
     *
     * @param Notification $notification
     * @return void
     */
    public function allNotificationSeen(){
        $this->repo->updateAllNotificationAssSeen($this->getUser());
        $this->em->flush();
        return $this->redirectToRoute('notification_all');
    }
}



// $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
// $normalizers = [new ObjectNormalizer()];
// $serializer = new Serializer($normalizers, $encoders);

// $result=$this->repo->findBy(['user'=>$this->getUser(),'seen'=>false]);
// // Serialize your object in Json
// $jsonObject = $serializer->serialize($result, 'json', [
//     'circular_reference_handler' => function ($object) {
//         return $object->getId();
//     }
// ]);

// return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
