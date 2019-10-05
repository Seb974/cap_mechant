<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Nutritionals;
use App\Entity\Pics;
use App\Entity\Product;
use App\Entity\Tva;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Faker\Generator;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getDependencies()
    {
        return array(
			TvaFixtures::class,
			CategoryFixtures::class,
		);
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $faker->addProvider( new \FakerRestaurant\Provider\fr_FR\Restaurant( $faker ) );

        $cycle   = 0;

		// category
		$burger  = $this->em->getRepository( Category::class )->findOneBy( ['name' => 'burger'         ] );
		$boisson = $this->em->getRepository( Category::class )->findOneBy( ['name' => 'boisson'        ] );
		$laitier = $this->em->getRepository( Category::class )->findOneBy( ['name' => 'produit laitier'] );
		$legume  = $this->em->getRepository( Category::class )->findOneBy( ['name' => 'legume'         ] );
		$fruit   = $this->em->getRepository( Category::class )->findOneBy( ['name' => 'fruits'         ] );
		$plats   = $this->em->getRepository( Category::class )->findOneBy( ['name' => 'plats cuisinés' ] );

		// tva
		$tva_alcool = $this->em->getRepository( Tva::class )->findOneBy( ['taux' => 0.085 ] );
		$tva_food   = $this->em->getRepository( Tva::class )->findOneBy( ['taux' => 0.021 ] );

        for ( $i = 0; $i < 100; $i++ ) {
            switch ( $cycle ) {
                case 0:
					$product_name     = $faker->foodname();
					$product_category = $burger           ;
					$product_tva      = $tva_food         ;
                    break;

                case 1:
					$product_name     = $faker->beverageName();
					$product_category = $boisson              ;
					$product_tva      = $tva_alcool           ;
                    break;

                case 2:
					$product_name     = $faker->dairyName();
					$product_category = $laitier           ;
					$product_tva      = $tva_food          ;
                    break;

                case 3:
					$product_name     = $faker->vegetableName();
					$product_category = $legume                ;
					$product_tva      = $tva_food              ;
                    break;

                case 4:
					$product_name     = $faker->fruitName();
					$product_category = $fruit             ;
					$product_tva      = $tva_food          ;
                    break;

                case 5:
					$product_name     = $faker->meatName();
					$product_category = $plats            ;
					$product_tva      = $tva_food         ;
                    break;

                default:
                    # code...
                    break;
            }

			$picture = new Pics();
			$rnd = random_int( 0, 100 );
			$picture->setB64("https://loremflickr.com/640/480/{$product_name}?random={$rnd}");
			$manager->persist( $picture );

			$nutri = new Nutritionals();
			$nutri->setKJ           ( random_int( 0, 100 ) );
			$nutri->setKCal         ( random_int( 0, 100 ) );
			$nutri->setProtein      ( random_int( 0, 100 ) );
			$nutri->setCarbohydrates( random_int( 0, 100 ) );
			$nutri->setSugar        ( random_int( 0, 100 ) );
			$nutri->setFat          ( random_int( 0, 100 ) );
			$nutri->setTransAG      ( random_int( 0, 100 ) );
			$nutri->setSalt         ( random_int( 0, 100 ) );
			$manager->persist( $nutri );

			$product = new Product();
            $product->setName        ( $product_name                                             );
            $product->setDescription ( $faker->sentence( $nbWords = 4, $variableNbWords = true ) );
            $product->setCategory    ( $product_category                                         );
            $product->setTva         ( $product_tva                                              );
            $product->setPicture     ( $picture                                                  );
            $product->setNutritionals( $nutri                                                    );
            $manager->persist( $product );

            $cycle++;
            if ( 6 == $cycle ) {
                $cycle = 0;
            }
        }
        $manager->flush();
    }
}
