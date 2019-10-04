<?php

namespace App\DataFixtures;

use App\Entity\Allergen;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

		$zipcodes = array(
			array('name' => 'gluten'),
			array('name' => 'crustacés'),
			array('name' => 'oeufs'),
			array('name' => 'poissons'),
			array('name' => 'arachides'),
			array('name' => 'soja'),
			array('name' => 'lait'),
			array('name' => 'fruits à coques'),
			array('name' => 'céleri'),
			array('name' => 'moutarde'),
			array('name' => 'graines de sésame'),
			array('name' => 'Anhydride sulfureux et sulfites'),
			array('name' => 'Lupin'),
			array('name' => 'Mollusques'),
		  );

		foreach ( $Allergens as $key => $value ) {
			$allergen = new Allergen();

			$allergen->setName( $value['name'] );

			$manager->persist( $allergen );
		}

        $manager->flush();
    }
}
