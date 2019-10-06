<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Variant;
use App\Entity\CartItem;
use App\Form\CartItemType;
use App\Repository\CartItemRepository;
use App\Repository\VariantRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cartitem")
 */
class CartItemController extends AbstractController
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

        return $this->redirectToRoute('product_index');
    }

    /**
     * @Route("/current", name="get_cart_item", methods={"GET"})
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
     * @Route("/{id}/edit", name="cart_item_edit", methods={"GET","POST"})
     */
    public function edit($id, Request $request, CartService $cartService) : Response
    {
        $newQty = $request->request->get($id);
        $cartService->update($id, $newQty);
        return $this->redirectToRoute('get_cart_item');
    }

    /**
     * @Route("/{id}", name="cart_item_delete", methods={"DELETE"})
     */
    public function delete($id, CartService $cartService): Response
    {
        $cartService->remove($id);

        return $this->redirectToRoute('get_cart_item');
    }

}
