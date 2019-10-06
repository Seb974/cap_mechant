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
    public function add(Request $request, CartService $cartService, VariantRepository $variantRepository): Response
    {
        $variant = $variantRepository->find($request->query->get('id'));
        $quantity = $request->request->get($request->query->get('id'));
        $cartService->add($variant, $quantity);

        return $this->redirectToRoute('product_index');
    }

    /**
     * @Route("/current", name="get_cart_item", methods={"GET"})
     */
    public function getCurrentCart(CartService $cartService)
    {
        return $this->render('cart_item/showCurrent.html.twig', [
            'currentCart' => $cartService->getFullCart(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cart_item_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CartItem $cartItem): Response
    {
        $newQty = (int) $request->request->get($cartItem->getId());
        $cartItem->setQuantity($newQty);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cartItem);
        $entityManager->flush();
        return $this->redirectToRoute('get_cart_item');
    }

    /**
     * @Route("/{id}", name="cart_item_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CartItem $cartItem): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cartItem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cartItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('get_cart_item');
    }

}
