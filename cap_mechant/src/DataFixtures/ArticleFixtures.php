<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getDependencies()
    {
        return array(
			CategoryFixtures::class,
		);
    }

    public function load(ObjectManager $manager)
    {
        $cycle = 0;
        $faker = Factory::create();
        $faker->addProvider( new \FakerRestaurant\Provider\fr_FR\Restaurant( $faker ) );

        // categories
		$carris  = $this->em->getRepository( Category::class )->findOneBy( ['name' => 'Carris'                                      ] );
		$salades = $this->em->getRepository( Category::class )->findOneBy( ['name' => 'Salades'                                     ] );
		$brochettes = $this->em->getRepository( Category::class )->findOneBy( ['name' => 'Brochettes'                               ] );
		$samoussas  = $this->em->getRepository( Category::class )->findOneBy( ['name' => 'Samoussas'                                ] );
		$desserts   = $this->em->getRepository( Category::class )->findOneBy( ['name' => 'Desserts - Patisseries'                   ] );
        $consommables   = $this->em->getRepository( Category::class )->findOneBy( ['name' => 'Produits d\'entretien - consommables' ] );


        for ( $i = 0; $i < 25; $i++ ) {
            switch ( $cycle ) {
				case 0:
					$product_name     = $faker->foodname();
					$product_category = $carris;
                    break;

                case 1:
                    // $product_name     = "Salade de " + $faker->vegetableName();
                    $product_name     = $faker->vegetableName();
					$product_category = $salades;
                    break;

                case 2:
                    // $product_name     = "Brochette de " + $faker->meatName();
                    $product_name     = $faker->meatName();
					$product_category = $brochettes;
                    break;

                case 3:
                    // $product_name     = "Samoussas au " + $faker->meatName();
                    $product_name     = $faker->meatName();
					$product_category = $samoussas;
                    break;

                case 4:
                    // $product_name     = "Crumble au " + $faker->fruitName();
                    $product_name     = $faker->fruitName();
					$product_category = $desserts;
                    break;

                case 5:
                    // $product_name     = "Consommable " + $i;
                    $product_name     = $i;
					$product_category = $consommables;
                    break;

                default:
                    # code...
                    break;
            }

			// $picture = new Pics();
			// $picture->setB64("https://loremflickr.com/320/240/{$product_name}");
			// $manager->persist( $picture );

			$product = new Article();
            $product->setName        ( $product_name                                             );
            $product->setCategory    ( $product_category                                         );
            $manager->persist( $product );

            $cycle++;
            if ( 6 == $cycle ) {
                $cycle = 0;
			}
        }
        $manager->flush();
    }
}
