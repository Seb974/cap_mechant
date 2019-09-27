<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AllergenRepository")
 */
class Allergen
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $names = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNames(): ?array
    {
        return $this->names;
    }

    public function setNames(?array $names): self
    {
        $this->names = $names;

        return $this;
    }
}
