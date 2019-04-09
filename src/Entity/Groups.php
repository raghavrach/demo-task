<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Groups
 *
 * @ORM\Table(name="groups", indexes={@ORM\Index(name="name_isDeleted", columns={"name", "isDeleted"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\GroupsRepository")
 */
class Groups
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message= "Name is required")
     * @Assert\Length(
     *     min = "2",
     *  max = "250"
     * )
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;
    
    /**
     * @var boolean
     * @ORM\Column(name="isDeleted", type="boolean", options={"default"="0"})
     */
    private $isDeleted = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdOn", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdOn = 'CURRENT_TIMESTAMP';

    /**
     * @var int
     *
     * @ORM\Column(name="createdById", type="integer", nullable=false)
     */
    private $createdById;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updatedOn", type="datetime", nullable=true)
     */
    private $updatedOn;

    /**
     * @var int|null
     *
     * @ORM\Column(name="updatedById", type="integer", nullable=true)
     */
    private $updatedById;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="groups")
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsDeleted(): ?string
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(string $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->createdOn;
    }

    public function setCreatedOn(\DateTimeInterface $createdOn): self
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    public function getCreatedById(): ?int
    {
        return $this->createdById;
    }

    public function setCreatedById(int $createdById): self
    {
        $this->createdById = $createdById;

        return $this;
    }

    public function getUpdatedOn(): ?\DateTimeInterface
    {
        return $this->updatedOn;
    }

    public function setUpdatedOn(?\DateTimeInterface $updatedOn): self
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    public function getUpdatedById(): ?int
    {
        return $this->updatedById;
    }

    public function setUpdatedById(?int $updatedById): self
    {
        $this->updatedById = $updatedById;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $users->addGroups($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $users->removeGroups($this);
        }

        return $this;
    }
    
   /**
    * Check if Users collection has a user entity
    * 
    * @param $user User entity object
    * @return boolean
    */ 
   public function hasUser(Users $user)
   {
       return $this->users->contains($user);
   }

}
