<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/add", name="cart_item_add", methods={"GET","POST"})
     */
    public function add(Request $request, CartService $cartService): Response
    {
        //$variant = $variantRepository->find($request->query->get('id'));
        $id = $request->query->get('id');
        $quantity = $request->request->get($request->query->get('id'));
        $cartService->add($id, $quantity);
        $this->updateCartEntityIfExists($cartService);

        return $this->redirectToRoute('product_index');
    }

    /**
     * @Route("/current", name="get_cart", methods={"GET"})
     */
    public function getCurrentCart(CartService $cartService)
    {
        $totalToPay = 0;
        $totalTax = 0;
        $cart = $cartService->getCart();
        foreach ($cart as $item) {
            $totalToPay += $item['product']->getPrice() * $item['quantity'];
            $totalTax += $totalToPay * $item['product']->getProduct()->getTva()->getTaux();
        }
        return $this->render('cart_item/showCurrent.html.twig', [
            'currentCart' => $cart,
            'totalToPay' => $totalToPay,
            'totalTax' => $totalTax,
        ]);
    }

    /**
     * @Route("/validation", name="cart_validate", methods={"GET"})
     */
    public function validate(CartService $cartService): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }
        if (!$user->getCart()) {
            $cartService->generateCartEntity($user);
        }
        return $this->redirectToRoute('variant_index');
    }

    /**
     * @Route("/{id}/edit", name="cart_item_edit", methods={"GET","POST"})
     */
    public function edit($id, Request $request, CartService $cartService) : Response
    {
        $newQty = $request->request->get($id);
        $cartService->update($id, $newQty);
        $this->updateCartEntityIfExists($cartService);

        return $this->redirectToRoute('get_cart');
    }

    /**
     * @Route("/{id}", name="cart_item_delete", methods={"DELETE"})
     */
    public function delete($id, CartService $cartService): Response
    {
        $cartService->remove($id);
        $this->updateCartEntityIfExists($cartService);

        return $this->redirectToRoute('get_cart');
    }

    private function updateCartEntityIfExists(CartService $cartService)
    {
        $user = $this->getUser();
        if ($user) {
            if ($user->getCart()) {
                $cartService->updateCartEntity($user->getCart());
            }
        }
    }

    /**
     * @Route("/disconnect", name="disconnect")
     */
    public function disconnect(CartService $cartService)
    {
        $cart = $cartService->getCart();
        $user = $this->getUser();
        if (!empty($cart)) {
            if (!$user->getCart()) {
                $cartService->generateCartEntity($user);
            }
        }
        return $this->redirectToRoute('logout');
    }
}
