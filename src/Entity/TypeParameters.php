<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="TBL_ADMIN_PARAMETERS_TYPES")
 * @ORM\Entity(repositoryClass="App\Repository\TypeParametersRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TypeParameters
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="ID", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="NAME", type="string", length=191, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(name="IS_ACTIVE", type="boolean")
     */
    private $is_active;

    /**
     * @ORM\PrePersist()
     */
    public function setPrePersistData() {

        $this->is_active = true;
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

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }
}