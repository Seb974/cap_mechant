<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Repository\CartItemRepository;
use App\Entity\Variant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    protected $session;
    protected $entityManager;
    protected $cartItemRepository;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager, CartItemRepository $cartItemRepository) {
        $this->session = $session;
        $this->cartItemRepository = $cartItemRepository;
        $this->entityManager = $entityManager;
    }

    public function add(Variant $product, float $quantity) {
        $cart = $this->session->get('cart', new Cart());
        foreach($cart->getCartItems() as $cartItem) {
            if ($cartItem->getProduct()->getId() === $product->getId()) {
                $cartItem->setQuantity($cartItem->getQuantity() +  $quantity);
                $this->setTotals($cart);
                $this->entityManager->flush();
                $this->session->set('cart', $cart);
                return ;
            }
        }
        $this->addNewCartItem($cart, $product, $quantity);
    }

    public function remove(CartItem $cartItem) {
        $cart = $this->session->get('cart', new Cart());
        foreach($cart->getCartItems() as $registeredCartItem) {
            if ($registeredCartItem->getId() == $cartItem->getId()) {
                $cart->removeCartItem($registeredCartItem);
                $this->setTotals($cart);
                $this->entityManager->flush();
                $this->session->set('cart', $cart);
                return ;
            }
        }
    }

    public function update(CartItem $cartItem, float $newQty) {
        $cart = $this->session->get('cart', new Cart());
        foreach($cart->getCartItems() as $registeredCartItem) {
            if ($registeredCartItem->getId() == $cartItem->getId()) {
                $registeredCartItem->setQuantity($newQty);
                $this->setTotals($cart);
                $this->entityManager->flush();
                $this->session->set('cart', $cart);
                return ;
            }
        }
    }

    public function getFullCart() : ?Cart {
        $cart = $this->session->get('cart', new Cart());
        $this->session->set('cart', $cart);
        return $cart;
    }

    private function setTotals(Cart $cart) {
        $totalToPay = 0;
        $totalTax = 0;
        foreach($cart->getCartItems() as $cartItem) {
            $totalToPay += ( $cartItem->getProduct()->getPrice() * $cartItem->getQuantity() );
            $totalTax += ($totalToPay * $cartItem->getProduct()->getProduct()->getTva()->getTaux());
        }
        $cart->setTotalToPay($totalToPay);
        $cart->setTotalTax($totalTax);
    }

    private function addNewCartItem(Cart $cart, Variant $product, float $quantity) {
        $cartItem = $this->createNewCartItem($product, $quantity);
        $cart->addCartItems($cartItem);
        $cart->setIsValidated(false);
        $this->setTotals($cart);
        $this->session->set('cart', $cart);

    }

    private function createNewCartItem(Variant $product, float $quantity) : ?CartItem {
        $cartItem = new CartItem();
        $cartItem->setProduct($product);
        $cartItem->setQuantity($quantity);
        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();

        return $cartItem;
    }

}