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
        $faker = Factory::create();
        $faker->addProvider( new \FakerRestaurant\Provider\fr_FR\Restaurant( $faker ) );

        $cycle = 0;
        $name  = "";

        for ( $i = 0; $i < 100; $i++ ) {
            switch ( $cycle ) {
                case 0:
                    $name = $faker->foodname();
                    break;

                case 1:
                    $name = $faker->beverageName();
                    break;

                case 2:
                    $name = $faker->dairyName();
                    break;

                case 3:
                    $name = $faker->vegetableName();
                    break;

                case 4:
                    $name = $faker->fruitName();
                    break;

                case 5:
                    $name = $faker->meatName();
                    break;

                default:
                    # code...
                    break;
            }

            $product = new Product();

            $product->setName        ( $name                                                          );
            $product->setDescription ( $faker->sentence( $nbWords = 4, $variableNbWords = true )      );
            // $product->setPrice       ( $faker->randomFloat( $nbMaxDecimals = 2, $min = 5, $max = 15 ) );
            $manager->persist        ( $product                                                       );

            $cycle++;
            if ( 5 == $cycle ) {
                $cycle = 0;
            }
        }

        $manager->flush();
    }
}
