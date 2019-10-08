<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $payment_id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $payment_type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     */
    private $totalToPay_TTC;

    /**
     * @ORM\Column(type="float")
     */
    private $totalToPay_HT;

    /**
     * @ORM\Column(type="float")
     */
    private $totalTax;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Supplier", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $supplier;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $orderStatus;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CartItem", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cartItem;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaymentId(): ?int
    {
        return $this->payment_id;
    }

    public function setPaymentId(int $payment_id): self
    {
        $this->payment_id = $payment_id;

        return $this;
    }

    public function getPaymentType(): ?string
    {
        return $this->payment_type;
    }

    public function setPaymentType(string $payment_type): self
    {
        $this->payment_type = $payment_type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTotalToPayTTC(): ?float
    {
        return $this->totalToPay_TTC;
    }

    public function setTotalToPayTTC(float $totalToPay_TTC): self
    {
        $this->totalToPay_TTC = $totalToPay_TTC;

        return $this;
    }

    public function getTotalToPayHT(): ?float
    {
        return $this->totalToPay_HT;
    }

    public function setTotalToPayHT(float $totalToPay_HT): self
    {
        $this->totalToPay_HT = $totalToPay_HT;

        return $this;
    }

    public function getTotalTax(): ?float
    {
        return $this->totalTax;
    }

    public function setTotalTax(float $totalTax): self
    {
        $this->totalTax = $totalTax;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(Supplier $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }

    public function getOrderStatus(): ?string
    {
        return $this->orderStatus;
    }

    public function setOrderStatus(string $orderStatus): self
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }

    public function getCartItem(): ?CartItem
    {
        return $this->cartItem;
    }

    public function setCartItem(CartItem $cartItem): self
    {
        $this->cartItem = $cartItem;

        return $this;
    }
}
