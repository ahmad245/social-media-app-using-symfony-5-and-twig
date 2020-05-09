<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $countryCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $countryName;

     /**
     * @ORM\OneToMany(targetEntity="App\Entity\User",mappedBy="country")
     */
    private $users;

    public function __construct()
    {
        $this->users=new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function setCountryName(string $countryName): self
    {
        $this->countryName = $countryName;

        return $this;
    }

    /**
     * Get the value of users
     */ 
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set the value of users
     *
     * @return  self
     */ 
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    public function __toString()
    {
        return $this->countryName;
    }
}
