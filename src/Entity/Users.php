<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Table(name="TBL_ADMIN_USERS")
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Users implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="ID", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(name="USERNAME", type="string", length=191, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(name="PASSWORD", type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(name="FIRST_NAME", type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\Column(name="LAST_NAME", type="string", length=255)
     */
    private $last_name;

    /**
     * @ORM\Column(name="ROLE", type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(name="EMAIL", type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(name="CREATED_AT", type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(name="UPDATED_AT", type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(name="IS_ACTIVE", type="boolean")
     */
    private $isActive;

    /**
     * Get Full name
     *
     * @return string
     */
    public function getFullName() {

        return $this->first_name.' '.$this->last_name;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setPrePersistData() {

        $this->isActive = true;
        $this->created_at = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function setPreUpdateData() {

        $this->updated_at = new \DateTime();
    }

    ## start login
    public function __construct()
    {
        $this->isActive = true;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return array($this->role);
    }

    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->first_name,
            $this->last_name,
            $this->email,
            $this->role,
            $this->isActive
        ));
    }
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->first_name,
            $this->last_name,
            $this->email,
            $this->role,
            $this->isActive
            ) = unserialize($serialized);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}