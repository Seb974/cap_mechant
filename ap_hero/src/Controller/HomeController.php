<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    public function index()
    {
        $faker = Factory::create();
        $faker->addProvider( new \FakerRestaurant\Provider\fr_FR\Restaurant( $faker ) );

        $product = new Product();
        $product->setName       ( $faker->foodName() );
        $product->setDescription( $faker->sentence( $nbWords = 4, $variableNbWords = true )      );
        $product->setPrice      ( $faker->randomFloat( $nbMaxDecimals = 2, $min = 5, $max = 15 ) );

        dump( $product );
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}