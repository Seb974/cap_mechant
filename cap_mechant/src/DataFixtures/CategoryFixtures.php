<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = array(
			array('name' => 'Carris'),
			array('name' => 'Salades'),
			array('name' => 'Brochettes'),
			array('name' => 'Samoussas'),
			array('name' => 'Desserts - Patisseries'),
			array('name' => 'Produits d\'entretien - consommables')
		  );

        foreach ( $categories as $key => $value ) {
			$category = new Category();
			$category->setName( $value['name'] );
			$manager->persist($category);
		}
        $manager->flush();
    }
}
