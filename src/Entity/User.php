<?php

namespace App\Entity;
use App\Entity\Post;
use App\Entity\Role;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("email")
 *  @Vich\Uploadable()
 */
class User implements UserInterface, \Serializable
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *  min=2,
     *  max=30,
     * minMessage="Your First Name  must be at least {{ limit }} characters long",
     * maxMessage="Your First Name  cannot be longer than {{ limit }} characters"
     * )
     *   @Groups("user")
     *
     */
    private $firstName;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *  min=2,
     *  max=50,
     * minMessage="Your Last Name  must be at least {{ limit }} characters long",
     * maxMessage="Your Last Name  cannot be longer than {{ limit }} characters"
     * )
     * @Groups("user")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(
     *  min=3,
     *  max=255,
     * minMessage="Your Last Name  must be at least {{ limit }} characters long",
     * maxMessage="Your Last Name  cannot be longer than {{ limit }} characters"
     * )
     * @Groups("user")
     */
    private $email;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
      * @Assert\Length(
     *  min=2,
     *  max=255,
     * minMessage="Your Phone must be at least {{ limit }} characters long",
     * maxMessage="Your Phone  cannot be longer than {{ limit }} characters"
     * )
     * @Groups("user")
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     *
     */
    private $createAt;

    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $birthday;

  /**
     * @Vich\UploadableField(mapping="imagesUser", fileNameProperty="picture")
     * @Assert\NotNull()
     */
    private $file;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
    
     * @Groups("user")
     */
    private $picture;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
      * @Assert\Regex(
     *   pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}/",
     *   message="Password must be seven charachters and contain at least one digit,one uppercase and one lowercase"
     * )
     */
    private $password;

     /**
     *  @Assert\EqualTo(
     *   propertyPath="password",
     *     message="Passwords does not match"
     * )
     */

    private $confirmPassword;

   


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
      * @Assert\Length(
     *  min=5,
     *  max=255,
     * minMessage="Your introduction must be at least {{ limit }} characters long",
     * maxMessage="Your introduction  cannot be longer than {{ limit }} characters"
     * )
     */
    private $introduction;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(
     *  min=5,
     *  max=1025,
     * minMessage="Your bio must be at least {{ limit }} characters long",
     * maxMessage="Your bio  cannot be longer than {{ limit }} characters"
     * )
     */
    private $bio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post" , mappedBy="user")
     */
    private $posts;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", mappedBy="users")
     */
    private $userRoles;

    private $roles;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User" ,mappedBy="following")
  
     */
    private $followers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User" , inversedBy="followers")
     * @ORM\JoinTable(name="following",
     *       joinColumns={
     *                   @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     *            },
     *        inverseJoinColumns={
     *                   @ORM\JoinColumn(name="following_user_id",referencedColumnName="id")
     *         }
     * )
     */
    private $following;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Post" , inversedBy="likeBy")
     * @ORM\JoinTable(name="post_likes",
     *                joinColumns={@ORM\JoinColumn(name="user_id",referencedColumnName="id")},
     *                inverseJoinColumns={@ORM\JoinColumn(name="post_id",referencedColumnName="id")}
     * )
     */
   private $postsLiked;

   /**
    * @ORM\Column(type="string",nullable=true,length=30)
    */
   private $confirmationToken;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

 
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cities", inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
  
     */
     private $city;

      /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $country;


      /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="commentedBy",orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommentReply", mappedBy="user")
     */
    private $commentReplies;

    public function __construct()
    {
        $this->posts=new ArrayCollection();
        $this->userRoles=new ArrayCollection();
        $this->followers=new ArrayCollection();
        $this->following=new ArrayCollection();
        $this->postsLiked=new ArrayCollection();
        $this->comments=new ArrayCollection();
        $this->enabled=false;
        $this->commentReplies = new ArrayCollection();
    }

    /**
     * 
     */

    public function getId(){
        return $this->id;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Undocumented function
     *
     * @param string $firstName
     * @return self
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }
  
    /**
     * 
     */

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getFullName():?string
    {
        return $this->firstName.' '.$this->lastName ;
    }

    /**
     * Undocumented function
     *
     * @param string $lastName
     * @return self
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Undocumented function
     *
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * Undocumented function
     *
     * @param string|null $picture
     * @return self
     */
    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Undocumented function
     *
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    /**
     * Undocumented function
     *
     * @param string $confirmPassword
     * @return self
     */
    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    /**
     * Undocumented function
     *
     * @param string|null $introduction
     * @return self
     */
    public function setIntroduction(?string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * Undocumented function
     *
     * @param string|null $bio
     * @return self
     */
    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }


    ///////////////////////////////////////////////////
    
    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(){  return null;}

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername(){
        return $this->email;
    }

    public function setUsername(string $email):self
    {
         $this->username=$email;
         return $this;
    }
    public function fullName(){
        return " {$this->firstName} {$this->lastName} ";
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(){}

    public function getRoles(){
        $roles=  $this->userRoles->map(function($role){
             return $role->getName();
         })->toArray();
 
          $roles[]='ROLE_USER';
         
         return $roles;
     }

    ///////////////////////////////////////////
    /**
     * @return Collection|post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    /**
     * Undocumented function
     *
     * @param Post $post
     * @return self
     */
    public function addPost(Post $post):self
    {
        if(!$this->posts->contains($post)){
            $this->posts[]=$post;
            $post->setUser($this);
        }
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param Post $post
     * @return self
     */
    public function removePost(Post $post):self
    {
        if($this->posts->contains($post))
        {
            $this->posts->removeElement($post);

            if($post->getUser()==$this)
            {
                $post->setUser(null);
            }
        }
        return $this;
    }
    /////////////////////////////////////////
      /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    /**
     * Undocumented function
     *
     * @param Role $userRole
     * @return self
     */
    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param Role $userRole
     * @return self
     */
    public function removeUserRole(Role $userRole): self
    {
        if ($this->userRoles->contains($userRole)) {
            $this->userRoles->removeElement($userRole);
            $userRole->removeUser($this);
        }

        return $this;
    }





    /**
     * Undocumented function
     *
     * @return \DateTimeInterface|null
     */
    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    /**
     * Set the value of birthday
     *
     * @return  self
     */ 
    public function setBirthday(string $birthday)
    {
        try {

            $this->birthday  = new \DateTime($birthday);
        }
        catch(\Exception $e) {
           //Do Nothing
        }
      

        return $this;
    }

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone(string $phone)
    {
        $this->phone = $phone;

        return $this;
    }

    ///////////////////////////////////////////

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initDate(){
        $this->createAt=new  \DateTime();
    }

    /**
     * Undocumented function
     *
     * @return \DateTimeInterface|null
     */
    public function getCreateAt(): ?\DateTimeInterface 
    {
        return $this->createAt;
    }

   /**
    * Undocumented function
    *
    * @param \DateTimeInterface $createAt
    * @return self
    */
    public function setCreateAt(\DateTimeInterface $createAt):self
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get the value of followers
     *  @return Collection
     */ 
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * Set the value of followers
     *
     * @return  self
     */ 
    public function setFollowers($followers)
    {
        $this->followers = $followers;

        return $this;
    }

    /**
     * @return Collection
     * Get joinColumns={
     */ 
    public function getFollowing()
    {
        return $this->following;
    }

    /**
     * Set joinColumns={
     *
     * @return  self
     */ 
    public function setFollowing($following)
    {
        $this->following = $following;

        return $this;
    }

    public function addFollower(User $follower): self
    {
        if (!$this->followers->contains($follower)) {
            $this->followers[] = $follower;
            $follower->addFollowing($this);
        }

        return $this;
    }

    public function removeFollower(User $follower): self
    {
        if ($this->followers->contains($follower)) {
            $this->followers->removeElement($follower);
            $follower->removeFollowing($this);
        }

        return $this;
    }

    public function addFollowing(User $following): self
    {
        if (!$this->following->contains($following)) {
            $this->following[] = $following;
        }

        return $this;
    }

    public function removeFollowing(User $following): self
    {
        if ($this->following->contains($following)) {
            $this->following->removeElement($following);
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isFollowing(User $user){
        if($this->following->contains($user)) return true;
        return false;
    }
    
    

   
    // public function getAddress()
    // {
    //     return $this->address;
    // }

 
    // public function setAddress($address)
    // {
    //     $this->address = $address;

    //     return $this;
    // }

   /**
    * Set joinColumns={@ORM\JoinColumn(name="user_id",referencedColumnName="id")},
    *
    * @return  self
    */ 
   public function setPostsLiked($postsLiked)
   {
      $this->postsLiked = $postsLiked;

      return $this;
   }

   /**
    * Get joinColumns={@ORM\JoinColumn(name="user_id",referencedColumnName="id")},
    */ 
   public function getPostsLiked()
   {
      return $this->postsLiked;
   }

   /**
    * Undocumented function
    *
    * @param Post $post
    * @return self
    */
   public function addPostsLikes(Post $post):self
   {
    if (!$this->postsLiked->contains($post)) {
        $this->postsLiked[] = $post;
        $post->addLikeBy($this);
    }

    return $this;
   }

   /**
    * Undocumented function
    *
    * @param Post $post
    * @return self
    */
   public function removePostsLikes(Post $post):self
   {
    if ($this->postsLiked->contains($post)) {
        $this->postsLiked->removeElement($post);
        $post->removeLikeBy($this);
    }

    return $this;
   }


   public function serialize()
   {
       return serialize(
           [
               $this->id,
               $this->firstName,
               $this->lastName,
               $this->email,
               $this->password,
               $this->enabled
            
           ]
       );
   }

   public function unserialize($serialized)
   {
       list(
           $this->id,  
           $this->firstName,
           $this->lastName,
           $this->email, 
           $this->password,
           $this->enabled
           ) = unserialize($serialized);
   }

   /**
    * Get the value of confirmationToken
    */ 
   public function getConfirmationToken()
   {
      return $this->confirmationToken;
   }

   /**
    * Set the value of confirmationToken
    *
    * @return  self
    */ 
   public function setConfirmationToken($confirmationToken)
   {
      $this->confirmationToken = $confirmationToken;

      return $this;
   }

    /**
     * Get the value of enabled
     */ 
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set the value of enabled
     *
     * @return  self
     */ 
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

     /**
      * Get the value of city
      */ 
     public function getCity()
     {
          return $this->city;
     }

     /**
      * Set the value of city
      *
      * @return  self
      */ 
     public function setCity($city)
     {
          $this->city = $city;

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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommentReply[]
     */
    public function getCommentReplies(): Collection
    {
        return $this->commentReplies;
    }

    public function addCommentReply(CommentReply $commentReply): self
    {
        if (!$this->commentReplies->contains($commentReply)) {
            $this->commentReplies[] = $commentReply;
            $commentReply->setUser($this);
        }

        return $this;
    }

    public function removeCommentReply(CommentReply $commentReply): self
    {
        if ($this->commentReplies->contains($commentReply)) {
            $this->commentReplies->removeElement($commentReply);
            // set the owning side to null (unless already changed)
            if ($commentReply->getUser() === $this) {
                $commentReply->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of country
     */ 
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     * @return  self
     */ 
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }


    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file): void
    {
        $this->file = $file;
        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
         //   $this->createAt = new \DateTimeImmutable();
         $this->getCreateAt();
        }
        
    }
}
