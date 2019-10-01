<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\CartItem;
use App\Form\CartItemType;
use App\Repository\CartItemRepository;
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
     * @Route("/", name="cart_item_index", methods={"GET"})
     */
    public function index(CartItemRepository $cartItemRepository): Response
    {
        return $this->render('cart_item/index.html.twig', [
            'cart_items' => $cartItemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="cart_item_add", methods={"GET","POST"})
     */
    public function add(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Product::class);
        $cartItem = new CartItem();
        $product = $repository->find($request->query->get('id'));
        $cartItem->setProduct($product);
        $cartItem->setQuantity($request->request->get($request->query->get('id')));
        $cartItem->setUser($this->getUser());
        $entityManager->persist($cartItem);
        $entityManager->flush();
        return $this->redirectToRoute('product_index');
    }

    /**
     * @Route("/new", name="cart_item_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cartItem = new CartItem();
        $form = $this->createForm(CartItemType::class, $cartItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cartItem);
            $entityManager->flush();

            return $this->redirectToRoute('cart_item_index');
        }

        return $this->render('cart_item/new.html.twig', [
            'cart_item' => $cartItem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/current", name="get_cart_item", methods={"GET"})
     */
    public function getCurrentCart()
    {
        $currentUser = $this->getUser();
        // return $currentUser->getCart();
        return $this->render('cart_item/showCurrent.html.twig', [
            'currentCart' => $currentUser->getCart(),
        ]);
    }

    /**
     * @Route("/{id}", name="cart_item_show", methods={"GET"})
     */
    public function show(CartItem $cartItem): Response
    {
        return $this->render('cart_item/show.html.twig', [
            'cart_item' => $cartItem,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cart_item_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CartItem $cartItem): Response
    {
        $form = $this->createForm(CartItemType::class, $cartItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cart_item_index');
        }

        return $this->render('cart_item/edit.html.twig', [
            'cart_item' => $cartItem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editcart", name="cart_item_editcart", methods={"GET","POST"})
     */
    public function editCart(Request $request, CartItem $cartItem): Response
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
