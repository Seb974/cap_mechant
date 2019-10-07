<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Metadata;
use App\Form\EditSelfType;
use App\Controller\UserController;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Repository\MetadataRepository;
use Doctrine\Common\Collections\ArrayCollection;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        // if ($this->getUser()) {
        //    $this->redirectToRoute('target_path');
        // }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername(); 
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $this->createMetadata($form, $user);
            $user->setRoles(['ROLE_USER']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }










    /**
     * @Route("/account/edit", name="self_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder, MetadataRepository $metadataRepository): Response
    {
        $user = $this->getUser();
        $metadata = $user->getMetadata();
        dump($metadata);
        $form = $this->createForm(EditSelfType::class, $user);
        // if ($metadata) {
        //     $form->get('phone_number')->setData($metadata->getPhoneNumber());
        //     $form->get('line_1')->setData($metadata->getField());
        //     $form->get('line_2')->setData($metadata->getType());
        //     $form->get('city')->setData($metadata->getCity());
        // }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->updateMetadata($form, $user, $metadataRepository);

            if (strlen($form->get('password')->getData()) > 0) {
                $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));
            }
            $this->getDoctrine()->getManager()->flush();

            //  return $this->redirectToRoute('user_self_show');
        }

        return $this->render('user/edit_self.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    private function createMetadata($form, User $user)
    {
        $line_1 = $form->get('line_1')->getData();
        $line_2 = $form->get('line_2')->getData();
        $phone = strval($form->get('phone_number')->getData());
        $city = strval($form->get('city')->getData()->getId());
        $type1 = 'line_1';
        $type2 = 'line_2';
        $type3 = 'phone_number';
        $type4 = 'city';
        dump(gettype(strval($city)));
        if ($line_1) {
            $this->hydrateNewMetadata($line_1, $type1, $user);
        }
        if ($line_2) {
            $this->hydrateNewMetadata($line_2, $type2, $user);
        } else {
            $this->hydrateNewMetadata('None', $type2, $user);
        }
        if ($phone) {
            $this->hydrateNewMetadata($phone, $type3, $user);
        }
        if ($city) {
            $this->hydrateNewMetadata($city, $type4, $user);
        }
    }

    private function updateMetadata($form, User $user, MetadataRepository $metadataRepository)
    {
        $line_1 = $form->get('line_1')->getData();
        $line_2 = $form->get('line_2')->getData();
        $phone = strval($form->get('phone_number')->getData());
        $city = strval($form->get('city')->getData()->getId());
        $type1 = 'line_1';
        $type2 = 'line_2';
        $type3 = 'phone_number';
        $type4 = 'city';

        dump($metadata);
        if ($line_1) {
            $metadata = $metadataRepository->findBy(['user' => $this->getUser()->getId()]);
            dump($metadata[0]->getField());
            // $metadata->setField($line_1);
            // $metadata->setType($type1);
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($metadata);
            // $user->addMetadata($metadata);
            // $entityManager->flush();
        }
        // if ($line_2) {
        //     $metadata = $user->getMetadata();
        //     $metadata->setField($line_2);
        //     $metadata->setType($type2);
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($metadata);
        //     $user->addMetadata($metadata);
        //     $entityManager->flush();
        // }
        // if ($phone) {
        //     $metadata = $user->getMetadata();
        //     $metadata->setField($phone);
        //     $metadata->setType($type3);
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($metadata);
        //     $user->addMetadata($metadata);
        //     $entityManager->flush();
        // }
        // if ($city) {
        //     $metadata = $user->getMetadata();
        //     $metadata->setField($city);
        //     $metadata->setType($type4);
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($metadata);
        //     $user->addMetadata($metadata);
        //     $entityManager->flush();
        // }
            return $metadata;
        return null;
    }

    public function hydrateNewMetadata(String $field, String $type, User $user)
    {
        $metadata = new Metadata();
        $metadata->setField($field);
        $metadata->setType($type);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($metadata);
        $user->addMetadata($metadata);
        $entityManager->flush();
    }

    /**
     * @Route("/self", name="user_self_show", methods={"GET"})
     */
    public function show(MetadataRepository $metadataRepository): Response
    {
        return $this->render('user/show_self.html.twig', [
            'user' => $this->getUser(),
            'metadata' => $metadataRepository->findBy(['user' => $this->getUser()->getId()]),
        ]);
    }
 }
