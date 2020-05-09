<?php

namespace App\EventListener;

use App\Entity\Comment;
use App\Entity\CommentNotification;
use App\Entity\FollowingNotification;
use App\Entity\LikeNotification;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;

use Doctrine\ORM\Event\OnFlushEventArgs;


class LikeSubscriber implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush
        ];
    }
    public function onFlush(OnFlushEventArgs $args)
    {
       
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach($uow->getScheduledEntityInsertions() as $entityYpdate){
           
            if($entityYpdate instanceof Comment){
                $onwer=$entityYpdate;
                $notificationComment=new CommentNotification();
                $notificationComment->setUser($onwer->getPost()->getUser());
                $notificationComment->setComment($onwer);
                $notificationComment->setPost($onwer->getPost());
                $notificationComment->setCommentedBy($onwer->getUser());
    
               $em->persist($notificationComment);
               $uow->computeChangeSet($em->getClassMetadata(CommentNotification::class),$notificationComment);
            }
           
          
              
              
        }
        
        foreach ($uow->getScheduledCollectionUpdates() as $collectionUpdat) {
           
           
            if (!$collectionUpdat->getOwner() instanceof Post) {
                 if (!$collectionUpdat->getOwner() instanceof User) {
                    if (!$collectionUpdat->getOwner() instanceof Comment) {
                      
                          continue;
                    }
            }
        }

            if ('likeBy' !== $collectionUpdat->getMapping()['fieldName']){
             if ('following' !== $collectionUpdat->getMapping()['fieldName']) {
                 if('commentedBy' !== $collectionUpdat->getMapping()['fieldName']){
                   
                    continue;
                 }
               
                
            }
        }
            $insertDiff=$collectionUpdat->getInsertDiff();
            if(!count($insertDiff)){
               
                return;
            }
            
           

            if($collectionUpdat->getOwner() instanceof Post){
               
                $onwer=$collectionUpdat->getOwner();
                $notificationLike=new LikeNotification();
                $notificationLike->setUser($onwer->getUser());
                $notificationLike->setPost($onwer);
                $notificationLike->setLikedBy(reset($insertDiff));
    
               $em->persist($notificationLike);
               $uow->computeChangeSet($em->getClassMetadata(LikeNotification::class),$notificationLike);
             
            }
        
            else if($collectionUpdat->getOwner()  instanceof User){
               
                $onwer=$collectionUpdat->getOwner();
                $notificationFollowing=new FollowingNotification();
                $notificationFollowing->setUser(reset($insertDiff));
                $notificationFollowing->setFollowing($onwer);
              
    
               $em->persist($notificationFollowing);
               $uow->computeChangeSet($em->getClassMetadata(FollowingNotification::class),$notificationFollowing);
            }

          

        }
    }
}
