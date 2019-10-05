<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SupplierFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
		// for ( $i=0; $i < 20; $i++ ) {
		// 	$supplier = new Suppli();
		// 	$tva->setName( $value['name'] );
		// 	$tva->setTaux( $value['taux'] );
		// 	$manager->persist($tva);
		// }
        // $manager->flush();
    }
}
