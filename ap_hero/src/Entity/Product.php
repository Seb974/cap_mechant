<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pics", cascade={"persist", "remove"})
     */
    private $picture;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Nutritionals", cascade={"persist", "remove"})
     */
    private $nutritionals;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Allergen", cascade={"persist", "remove"})
     */
    private $allergens;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tva")
     */
    private $tva;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?Pics
    {
        return $this->picture;
    }

    public function setPicture(?Pics $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getNutritionals(): ?Nutritionals
    {
        return $this->nutritionals;
    }

    public function setNutritionals(?Nutritionals $nutritionals): self
    {
        $this->nutritionals = $nutritionals;

        return $this;
    }

    public function getAllergens(): ?Allergen
    {
        return $this->allergens;
    }

    public function setAllergens(?Allergen $allergens): self
    {
        $this->allergens = $allergens;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTva(): ?Tva
    {
        return $this->tva;
    }

    public function setTva(?Tva $tva): self
    {
        $this->tva = $tva;

        return $this;
    }
}
