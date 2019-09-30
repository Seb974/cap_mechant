<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CartItem")
     */
    private $CartItem;

    /**
     * @ORM\Column(type="float")
     */
    private $total_cost;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_validated;

    public function __construct()
    {
        $this->CartItem = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|CartItem[]
     */
    public function getCartItem(): Collection
    {
        return $this->CartItem;
    }

    public function addCartItem(CartItem $cartItem): self
    {
        if (!$this->CartItem->contains($cartItem)) {
            $this->CartItem[] = $cartItem;
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): self
    {
        if ($this->CartItem->contains($cartItem)) {
            $this->CartItem->removeElement($cartItem);
        }

        return $this;
    }

    public function getTotalCost(): ?float
    {
        return $this->total_cost;
    }

    public function setTotalCost(float $total_cost): self
    {
        $this->total_cost = $total_cost;

        return $this;
    }

    public function getIsValidated(): ?bool
    {
        return $this->is_validated;
    }

    public function setIsValidated(bool $is_validated): self
    {
        $this->is_validated = $is_validated;

        return $this;
    }
}
