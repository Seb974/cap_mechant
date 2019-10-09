<?php

namespace App\Service\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Orders;
use App\Entity\User;
use App\Repository\CartItemRepository;
use App\Entity\Variant;
use App\Repository\VariantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    protected $session;
    protected $entityManager;
    protected $cartItemRepository;
    protected $variantRepository;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager, CartItemRepository $cartItemRepository, VariantRepository $variantRepository) {
        $this->session = $session;
        $this->cartItemRepository = $cartItemRepository;
        $this->variantRepository = $variantRepository;
        $this->entityManager = $entityManager;
    }

    public function add(int $id, float $quantity)
    {
        $cart = $this->session->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }
        $this->session->set('cart', $cart);
    }

    public function remove(int $id)
    {
        $cart = $this->session->get('cart', []);
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }
        $this->session->set('cart', $cart);
    }

    public function update(int $id, float $newQty)
    {
        $cart = $this->session->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id] = $newQty;
        }
        $this->session->set('cart', $cart);
    }

    public function getCart(): array
    {
        $cart = $this->session->get('cart', []);
        $cartWithData = [];

        foreach($cart as $id => $quantity) {
            $cartWithData[] = [
                'product' => $this->variantRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $cartWithData;
    }

    public function generateCartSession(Cart $cartEntity)
    {
        $cart = [];
        foreach ($cartEntity->getCartItems() as $cartItem) {
            $cart[$cartItem->getProduct()->getId()] = $cartItem->getQuantity();
        }
        $this->session->set('cart', $cart);
    }

    public function generateCartEntity(User $user) : ?Cart
    {
        $cart = $this->session->get('cart', []);
        $cartEntity = $user->getCart() ? $user->getCart() : new Cart();
        foreach($cart as $id => $quantity) {
            $cartItem = new CartItem();
            $cartItem->setProduct($this->variantRepository->find($id));
            $cartItem->setQuantity($quantity);
            $cartItem->setIsPaid(false);
            $cartEntity->addCartItems($cartItem);
            $this->entityManager->persist($cartItem);
        }
        $cartEntity->setTotalToPay($this->getTotalToPay($cartEntity));
        $cartEntity->setTotalTax($this->getTotalTax($cartEntity));
        $cartEntity->setUser($user);
        $cartEntity->setIsValidated(false);
        $this->entityManager->persist($cartEntity);
        $this->entityManager->flush();
        return $cartEntity;
    }

    public function updateCartEntity(Cart $cartEntity) : ?Cart
    {
        $cart = $this->session->get('cart', []);
        $cartEntity = $this->clearCartItems($cartEntity);
        foreach($cart as $id => $quantity) {
            $cartItem = new CartItem();
            $cartItem->setProduct($this->variantRepository->find($id));
            $cartItem->setQuantity($quantity);
            $cartItem->setIsPaid(false);
            $cartEntity->addCartItems($cartItem);
            $this->entityManager->persist($cartItem);
        }
        $cartEntity->setTotalToPay($this->getTotalToPay($cartEntity));
        $cartEntity->setTotalTax($this->getTotalTax($cartEntity));
        $this->entityManager->flush();
        return $cartEntity;
    }

    public function convertCartToOrders( Cart $cartEntity, string $internalId, string $paymentId, string $paymentType ) {

        foreach ($cartEntity->getCartItems() as $cartItem) {
            $order = new Orders();
            $order->setInternalId   ( $internalId                                                );
            $order->setPaymentId    ( $paymentId                                                 );
            $order->setPaymentType  ( $paymentType                                               );
            $order->setUser         ( $cartEntity->getUser()                                     );
            $order->setCartItem     ( $cartItem                                                  );
            $order->setTaxRate      ( $cartItem->getProduct()->getProduct()->getTva()->getTaux() );
            $order->setTotalToPayTTC( $cartItem->getProduct()->getPrice()                        );
            $order->setTotalToPayHT ( $order->getTotalToPayTTC() / ( 1 + $order->getTaxRate() )  );
            $order->setTotalTax     ( $order->getTotalToPayTTC() - $order->getTotalTax()         );
            $order->setSupplier     ( $cartItem->getProduct()->getProduct()->getSupplier()       );
            $order->setOrderStatus  ( "PENDING"                                                  );
            $order->setCartId       ( $cartEntity->getId()                                       );
			$this->entityManager->persist( $order );
		}
		$this->entityManager->flush();
    }

    public function decreaseStock(Cart $cart) {
        foreach ($cart->getCartItems() as $cartItem) {
            $stock = $cartItem->getProduct()->getStock();
            $quantitySold = $cartItem->getQuantity();
            $newQty = ($stock->getQuantity() - $quantitySold) > 0 ? ($stock->getQuantity() - $quantitySold) : 0;
            $stock->setQuantity($newQty);
            $this->entityManager->flush();
        }
    }
    
    public function initCart(Cart $cartEntity) {
        $this->clearCartItems($cartEntity);
        $cartEntity->setTotalToPay(0);
        $cartEntity->setTotalTax(0);
        $cartEntity->setIsValidated(false);
        $this->entityManager->flush();
        $this->session->set('cart', []);
    }

    private function clearCartItems(Cart $cartEntity) : ?Cart
    {
        foreach($cartEntity->getCartItems() as $cartItem) {
                $cartEntity->removeCartItem($cartItem);
        }
        $this->entityManager->flush();
        return $cartEntity;
    }

    private function getTotalToPay(Cart $cart)
    {
        $totalToPay = 0;
        foreach($cart->getCartItems() as $cartItem) {
            $totalToPay += ( $cartItem->getProduct()->getPrice() * $cartItem->getQuantity() );
        }
        return $totalToPay;
    }

    private function getTotalTax(Cart $cart)
    {
        $totalTax = 0;
        foreach($cart->getCartItems() as $cartItem) {
            $tva = $cartItem->getProduct()->getProduct()->getTva()->getTaux();
            $totalTax += ( $cartItem->getProduct()->getPrice() * $cartItem->getQuantity() * $tva);
        }
        return $totalTax;
    }

}
