<?php

namespace App\Service\Anonymize;

use App\Entity\Cart;
use App\Entity\User;
use App\Entity\Metadata;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AnonymizeService
{
    protected $entityManager;
    protected $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function anonymize(User $user)
    {
        $dateTime = new \DateTime();
        $anonymousName = (string)$dateTime->getTimestamp();
        $user->setEmail($anonymousName.'X_xX@Xx-X'.$anonymousName.'.re');
        $user->setUsername('Anonyme');
        $user->setPassword($this->passwordEncoder->encodePassword($user, $anonymousName));
        $user->setIsBanned(true);
        $this->entityManager->flush();
    }
}