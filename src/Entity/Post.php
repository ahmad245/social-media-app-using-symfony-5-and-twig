<?php

namespace App\Entity;
use App\Entity\User;
use App\Entity\Image;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Post implements  \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     * min=2,
     * minMessage="Your firstName  must be at least {{ limit }} characters long"
     * )
     */
    private $content;
    //@Assert\DateTime
    /**
     * @ORM\Column(type="datetime")
   
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User" , inversedBy="posts" )
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User",mappedBy="postsLiked", fetch="EXTRA_LAZY")
    
     *
     */
    private $likeBy;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", mappedBy="posts", fetch="EXTRA_LAZY")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post",orphanRemoval=true, fetch="EXTRA_LAZY")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="post",orphanRemoval=true,cascade={"persist", "remove"})
     */
    private $images;



    public function __construct()
    {
        $this->likeBy=new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->images = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initDate(){
        $this->createAt=new \DateTime();
    }
    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }


    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


   
  

    /**
     * Get the value of likeBy
     */ 
    public function getLikeBy()
    {
        return $this->likeBy;
    }



    /**
     * Undocumented function
     *
     * @param User $user
     * @return boolean
     */
    public function isLikedBy(User $user){
        if ($this->likeBy->contains($user)) return true;
        return false;
    }
    /**
     * Undocumented function
     *
     * @param User $user
     * @return self
     */
    public function addLikeBy(User $user):self
    {
         if (!$this->isLikedBy($user)) {
            $this->likeBy[]=$user;
           $user->addPostsLikes($this);
        }
        return $this;

    }
    /**
     * Undocumented function
     *
     * @param User $user
     * @return self
     */
    public function removeLikeBy(User $user):self
    {
         if ($this->isLikedBy($user)) {
            $this->likeBy->removeElement($user);
            $user->removePostsLikes($this);
         }
        return $this;
    }



    
   public function serialize()
   {
       return serialize(
           [
               $this->id,
               $this->content,
               $this->createAt,
            
           ]
       );
   }

   public function unserialize($serialized)
   {
       list(
           $this->id, $this->content, $this->createAt
           ) = unserialize($serialized);
   }

   /**
    * @return Collection|Tag[]
    */
   public function getTags(): Collection
   {
       return $this->tags;
   }

   public function addTag(Tag $tag): self
   {
       
       if (!$this->tags->contains($tag)) {
           $this->tags[] = $tag;
           if($tag->getId()!==null)
          { $tag->addPost($this);}
       }

       return $this;
   }

   public function removeTag(Tag $tag): self
   {
       if ($this->tags->contains($tag)) {
           $this->tags->removeElement($tag);
           $tag->removePost($this);
       }

       return $this;
   }

      /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function addImage(Image $image)
    {
       
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setPost($this);
        }

        return $this;
    }

    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }
    public function __toString()
    {
        return $this->content;
    }
}
