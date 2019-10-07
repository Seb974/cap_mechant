<?php

namespace App\DataFixtures;

use App\Entity\Supplier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SupplierFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
		$suppliers = array(
			array('name' => 'Osaka'               ),
			array('name' => 'La Maison du Whisky' ),
			array('name' => 'BurgerMary'          ),
		  );

		foreach ( $suppliers as $key => $value ) {
			$supplier = new Supplier();
			$supplier->setName( $value['name'] );
			$manager->persist( $supplier );
		}

        $manager->flush();
    }
}
