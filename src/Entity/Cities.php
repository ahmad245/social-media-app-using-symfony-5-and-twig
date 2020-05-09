<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CitiesRepository")
 */
class Cities
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @Groups("city")
     */
    private $id;
      /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departments",inversedBy="cities")
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
    
     */
    private $inseeCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
    
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("city")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
    
     */
    private $slug;

    /**
     * @ORM\Column(type="integer",  nullable=true)
    
     */
    private $gpsLat;

    /**
     * @ORM\Column(type="integer",  nullable=true)
 
     */
    private $gpsLng;

    /**
     * @ORM\Column(type="boolean", nullable=true)
   
     */
    private $multi;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User",mappedBy="city")
     */
    private $users;

  

    public function __construct()
    {
        $this->users=new ArrayCollection();
    }

    public function getDepartment(){
        return $this->department;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInseeCode(): ?string
    {
        return $this->inseeCode;
    }

    public function setInseeCode(?string $inseeCode): self
    {
        $this->inseeCode = $inseeCode;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getGpsLat(): ?string
    {
        return $this->gpsLat;
    }

    public function setGpsLat(?string $gpsLat): self
    {
        $this->gpsLat = $gpsLat;

        return $this;
    }

    public function getGpsLng(): ?string
    {
        return $this->gpsLng;
    }

    public function setGpsLng(?string $gpsLng): self
    {
        $this->gpsLng = $gpsLng;

        return $this;
    }

    public function getMulti(): ?bool
    {
        return $this->multi;
    }

    public function setMulti(?bool $multi): self
    {
        $this->multi = $multi;

        return $this;
    }

    /**
     * Get the value of users
     *
     * @return  [type]
     */ 
    public function getUsers()
    {
        return $this->users;
    }

    public function __toString()
    {
        return $this->name;
    }
   
}
