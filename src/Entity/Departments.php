<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentsRepository")
 */
class Departments
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     *  @Groups("department")
     */
    private $id;
     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Regions",inversedBy="departments")
     */
    private $region;

     /**
     * @ORM\Column(type="string", length=255)
     * @Groups("department")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("department")
     */
    private $name;

   

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("department")
     */
    private $slug;

   

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cities",mappedBy="department")
     */
    private $cities;
    public function __construct()
    {
        $this->cities=new ArrayCollection();
    }

    public function getCities(){
        return $this->cities;
    }

    public function getRegion(){
        return $this->region;
    }
    public function getId(): ?int
    {
        return $this->id;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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
    public function __toString()
    {
        return $this->name;
    }
}
