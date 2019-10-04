<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

		$zipcodes = array(
			array('zip_code' => '97440','name' => 'ST ANDRE'),
			array('zip_code' => '97429','name' => 'PETITE ILE'),
			array('zip_code' => '97460','name' => 'ST PAUL'),
			array('zip_code' => '97430','name' => 'LE TAMPON'),
			array('zip_code' => '97412','name' => 'BRAS PANON'),
			array('zip_code' => '97438','name' => 'STE MARIE'),
			array('zip_code' => '97417','name' => 'ST DENIS'),
			array('zip_code' => '97480','name' => 'ST JOSEPH'),
			array('zip_code' => '97435','name' => 'ST PAUL'),
			array('zip_code' => '97433','name' => 'SALAZIE'),
			array('zip_code' => '97425','name' => 'LES AVIRONS'),
			array('zip_code' => '97470','name' => 'ST BENOIT'),
			array('zip_code' => '97400','name' => 'ST DENIS'),
			array('zip_code' => '97432','name' => 'ST PIERRE'),
			array('zip_code' => '97410','name' => 'ST PIERRE'),
			array('zip_code' => '97437','name' => 'ST BENOIT'),
			array('zip_code' => '97490','name' => 'ST DENIS'),
			array('zip_code' => '97419','name' => 'LA POSSESSION'),
			array('zip_code' => '97434','name' => 'ST PAUL'),
			array('zip_code' => '97442','name' => 'ST PHILIPPE'),
			array('zip_code' => '97420','name' => 'LE PORT'),
			array('zip_code' => '97411','name' => 'ST PAUL'),
			array('zip_code' => '97413','name' => 'CILAOS'),
			array('zip_code' => '97421','name' => 'ST LOUIS'),
			array('zip_code' => '97431','name' => 'LA PLAINE DES PALMISTES'),
			array('zip_code' => '97439','name' => 'STE ROSE'),
			array('zip_code' => '97418','name' => 'LE TAMPON'),
			array('zip_code' => '97436','name' => 'ST LEU'),
			array('zip_code' => '97423','name' => 'ST PAUL'),
			array('zip_code' => '97424','name' => 'ST LEU'),
			array('zip_code' => '97416','name' => 'ST LEU'),
			array('zip_code' => '97450','name' => 'ST LOUIS'),
			array('zip_code' => '97414','name' => 'ENTRE DEUX'),
			array('zip_code' => '97426','name' => 'LES TROIS BASSINS'),
			array('zip_code' => '97422','name' => 'ST PAUL'),
			array('zip_code' => '97427','name' => 'L ETANG SALE'),
			array('zip_code' => '97441','name' => 'STE SUZANNE')
		  );

		foreach ( $zipcodes as $key => $value ) {
			$city = new City();

			$city->setZipCode( intval( $value['zip_code'] ) );
			$city->setName   ( $value['name'    ] );
			$city->setIsDeliverable( true );

			$manager->persist($city);
		}

        $manager->flush();
    }
}
