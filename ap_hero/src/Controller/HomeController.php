<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Cart\CartService;
use App\Repository\VariantRepository;
use App\Repository\ProductRepository;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ProductRepository $productRepository, CartService $cartService): Response
    {
        $user = $this->getUser();
        if ($user) {
            if ($user->getCart() && empty($cartService->getCart())) {
                $cartService->generateCartSession($user->getCart());
            }
        }
        return $this->render('home/index.html.twig', [
			'controller_name' => 'HomeController',
			'products' => $productRepository->findAll(),
        ]);
    }
}
