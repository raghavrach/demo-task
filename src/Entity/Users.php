<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})}, indexes={@ORM\Index(name="roleId", columns={"roleId"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users implements UserInterface
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
     *
     * @ORM\Column(name="name", type="string", length=256, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=32, nullable=true)
     */
    private $password;

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
     * @var \Roles
     *
     * @ORM\ManyToOne(targetEntity="Roles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="roleId", referencedColumnName="id")
     * })
     */
    private $role;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Groups", inversedBy="users")
     * @ORM\JoinTable(name="userGroups",
     *   joinColumns={
     *     @ORM\JoinColumn(name="userId", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="groupId", referencedColumnName="id")
     *   }
     * )
     */
    private $groups;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getRole(): ?Roles
    {
        return $this->role;
    }

    public function setRole(?Roles $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|Groups[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Groups $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
        }

        return $this;
    }

    public function removeGroup(Groups $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
        }

        return $this;
    }
    
    /**
    * Check if Groups collection has a group entity
    * 
    * @params $goup Group entity object
    * @retunr boolean
    */ 
    public function hasGroup(Groups $group)
    {
        return $this->groups->contains($group);
    }
    
     /**
     * Return username identity
     *
     * @return value
     */
    public function getUsername() :string
    {
        return $this->email;
    }
    
    /**
     * Returns the roles or permissions granted to the user for security.
     * 
     * @return array
     */
    public function getRoles() :array
    {
        return [$this->getRole()->getSlug()];
    }
    
    /**
     * Returns the salt that was originally used to encode the password.
     */
    public function getSalt()
    {
        
    }

    /**
     * Removes sensitive data from the user.
     */
    public function eraseCredentials()
    {
        
    }
}
