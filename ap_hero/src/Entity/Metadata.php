<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetadataRepository")
 */
class Metadata
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facturation_address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $delivery_address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone_number;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="metadata", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFacturationAddress(): ?string
    {
        return $this->facturation_address;
    }

    public function setFacturationAddress(?string $facturation_address): self
    {
        $this->facturation_address = $facturation_address;

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->delivery_address;
    }

    public function setDeliveryAddress(?string $delivery_address): self
    {
        $this->delivery_address = $delivery_address;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?int $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }
}
