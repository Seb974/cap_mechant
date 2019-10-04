<?php

namespace App\DataFixtures;

use App\Entity\Allergen;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AllergeneFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
		$allergens = array(
			array('name' => 'anhydride sulfureux et sulfites'),
			array('name' => 'arachides'                      ),
			array('name' => 'crustacés'                      ),
			array('name' => 'gluten'                         ),
			array('name' => 'oeufs'                          ),
			array('name' => 'poissons'                       ),
			array('name' => 'soja'                           ),
			array('name' => 'lait'                           ),
			array('name' => 'fruits à coques'                ),
			array('name' => 'céleri'                         ),
			array('name' => 'moutarde'                       ),
			array('name' => 'graines de sésame'              ),
			array('name' => 'lupin'                          ),
			array('name' => 'mollusques'                     ),
		  );

		foreach ( $allergens as $key => $value ) {
			$allergen = new Allergen();
			$allergen->setName( $value['name'] );
			$manager->persist( $allergen );
		}

        $manager->flush();
    }
}
