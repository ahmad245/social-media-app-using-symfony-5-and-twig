<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role{

    /**
     * @ORM\Id()
     *@ORM\GeneratedValue()
     *@ORM\Column(type="integer")
     */
    private $id;

    /**
     *@ORM\Column(type="string")
      * @Assert\NotBlank()
     * @Assert\Length(
     *  min=2,
     *  max=50,
     * minMessage="Your  Name Role must be at least {{ limit }} characters long",
     * maxMessage="Your  Name Role cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="userRoles")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


    /**
     * Undocumented function
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @return self
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @return self
     */
    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }


}