<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Cart\CartService;
use App\Repository\VariantRepository;

//test purpose only
//! Delete this part after pushing features
use Faker\Factory;
use Faker\Generator;
use App\Entity\Product;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(VariantRepository $variantRepository, CartService $cartService): Response
    {
        $user = $this->getUser();
        if ($user) {
            if ($user->getCart() && empty($cartService->getCart())) {
                $cartService->generateCartSession($user->getCart());
            }
        }
        return $this->render('home/index.html.twig', [
			'controller_name' => 'HomeController',
			'variants' => $variantRepository->findAll(),
        ]);
    }
}
