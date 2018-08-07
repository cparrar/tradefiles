<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="TBL_ADMIN_PARAMETERS", indexes={
 *     @ORM\Index(name="IDX_TBL_ADMIN_PARAMETERS_COLUMN_TYPE", columns={"TYPE"})
 * })
 * @ORM\Entity(repositoryClass="App\Repository\ParametersRepository")
 */
class Parameters
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="ID", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(name="NAME", type="string", length=191, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="TITLE", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="VALUE", type="text", nullable=true)
     */
    private $value;

    /**
     * @ORM\Column(name="DESCRIPTION", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \App\Entity\TypeParameters
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeParameters")
     * @ORM\JoinColumn(name="TYPE", referencedColumnName="ID")
     */
    private $type;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?TypeParameters
    {
        return $this->type;
    }

    public function setType(?TypeParameters $type): self
    {
        $this->type = $type;

        return $this;
    }
}