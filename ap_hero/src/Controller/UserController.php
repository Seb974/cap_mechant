<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Metadata;
use App\Form\CreateUserType;
use App\Form\UpdateUserType;
use App\Repository\UserRepository;
use App\Repository\MetadataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository, MetadataRepository $metadataRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'metadata' => $metadataRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(CreateUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));
            $this->updateMetadata($form, $user);
            $user->setRoles([$form->get('roles')->getData()]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $metadata = $user->getMetadata();
        $form = $this->createForm(UpdateUserType::class, $user);
        if ($metadata) {
            $form->get('phone_number')->setData($metadata->getPhoneNumber());
            $form->get('facturation_address')->setData($metadata->getFacturationAddress());
            $form->get('delivery_address')->setData($metadata->getDeliveryAddress());
            $form->get('city')->setData($metadata->getCity());
        }
        $form->get('roles')->setData($this->convertRoleToField($user));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateMetadata($form, $user);
            $user->setRoles([$form->get('roles')->getData()]);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('user_index');
    }

    private function updateMetadata($form, $user)
    {
        if ($user->getMetadata() === null ) {
            $metadata = new Metadata();
            $user->setMetadata($metadata);
        } else {
            $metadata = $user->getMetadata();
        }
        $facturation = $form->get('facturation_address')->getData();
        $delivery = $form->get('delivery_address')->getData();
        $phone = $form->get('phone_number')->getData();
        $city = $form->get('city')->getData();
        
        if ($facturation !== null && $delivery !== null && $phone !== null && $city !== null) {
            $metadata->setFacturationAddress($facturation);
            $metadata->setDeliveryAddress($delivery);
            $metadata->setPhoneNumber($phone);
            $metadata->setCity($city);
            return $metadata;
        }
        return null;
    }

    private function convertRoleToField($user)
    {
        $roles = $user->getRoles();
        if (in_array('ROLE_ADMIN', $roles)) {
            return 'ROLE_ADMIN';
        } elseif (in_array('ROLE_SUPPLIER', $roles)) {
            return 'ROLE_SUPPLIER';
        } elseif (in_array('ROLE_DELIVERER', $roles)) {
            return 'ROLE_DELIVERER';
        } else {
            return 'ROLE_USER';
        }
    }
}
