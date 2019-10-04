<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
	private $encoder;

	public function __construct(UserPasswordEncoderInterface $encoder ) {
        $this->encoder = $encoder;
	}

    public function load(ObjectManager $manager)
    {
		$users = array(
			array(
				'email' => 'm_seb@icloud.com',
				'roles' => 'ROLE_ADMIN',
				'password' => 'Soleil01',
				'username' => 'sebastien',
				'is_banned' => false
			),
			array(
				'email' => 'anne-marion.vitry@coding-academy.fr',
				'roles' => 'ROLE_ADMIN',
				'password' => 'azerty',
				'username' => 'Anna',
				'is_banned' => false
			),
			array(
				'email' => 'yen.linkwang@nigao.re',
				'roles' => 'ROLE_ADMIN',
				'password' => 'azerty',
				'username' => 'Yen',
				'is_banned' => false
			),
			array(
				'email' => 'contact@osaka.re',
				'roles' => 'ROLE_SUPPLIER',
				'password' => 'azerty',
				'username' => 'OSAKA',
				'is_banned' => false
			),
			array(
				'email' => 'cyclist@uber.com',
				'roles' => 'ROLE_DELIVERER',
				'password' => 'azerty',
				'username' => 'UberEats',
				'is_banned' => false
			),
			array(
				'email' => 'kevin@epitech.eu',
				'roles' => 'ROLE_USER',
				'password' => 'azerty',
				'username' => 'Kevin',
				'is_banned' => false
			),
			array(
				'email' => 'marvin@epitech.eu',
				'roles' => 'ROLE_USER',
				'password' => 'azerty',
				'username' => 'Marvin',
				'is_banned' => true
			),

		  );

		foreach ( $users as $key => $value ) {
			$user = new User();

			$user->setEmail    ( $value['email'     ] );
			$user->setUsername ( $value['username'  ] );
			$user->setIsBanned ( $value['is_banned' ] );

			$user->setRoles    ( array( $value['roles'] ) );
			$user->setPassword ( $this->encoder->encodePassword( $user, $value['password'] ) );

			$manager->persist( $user );
		}

        $manager->flush();
    }
}
