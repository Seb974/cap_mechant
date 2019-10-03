<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ProductFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager)
    {
        $faker   = Factory::create();
        $product = new Product();

        $product->setName($faker->name);
        $product->setDescription($faker->sentence($nbWords = 6, $variableNbWords = true));
        dump($product);
        
        // $manager->persist($product);

        // $manager->flush();
    }
}
