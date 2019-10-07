<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\VariantRepository;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(VariantRepository $variantRepository): Response
    {
        return $this->render('home/index.html.twig', [
			'controller_name' => 'HomeController',
			'variants' => $variantRepository->findAll(),
        ]);
    }
}
