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
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        $metadata = $user->getMetadata();
        $form = $this->createForm(EditSelfType::class, $user);
        $metadataTab = [];

        foreach ($metadata as $data) {
            $field = $data->getField();
            $type = $data->getType();
            $metadataTab += [$type => $field];
        }

        if ($metadataTab != []) {
            $form->get('phone_number')->setData($metadataTab['phone_number']);
            $form->get('line_1')->setData($metadataTab['line_1']);
            $form->get('line_2')->setData($metadataTab['line_2']);
            $form->get('city')->setData($metadataTab['city']);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->updateMetadata($form, $user);

            if (strlen($form->get('password')->getData()) > 0) {
                $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_self_show');
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

    private function updateMetadata($form, User $user)
    {
        $line_1 = $form->get('line_1')->getData();
        $line_2 = $form->get('line_2')->getData();
        $phone = strval($form->get('phone_number')->getData());
        $city = strval($form->get('city')->getData()->getId());
        $type1 = 'line_1';
        $type2 = 'line_2';
        $type3 = 'phone_number';
        $type4 = 'city';

            $metadata = $user->getMetadata()->unwrap();

            foreach ($metadata as $data) { 
                if ($data->getType() == $type1 && $line_1) {
                    $data->setField($line_1);
                };
                if ($data->getType() == $type2 && $line_2) {
                    $data->setField($line_2);
                } else {
                    $data->setField('None');
                };
                if ($data->getType() == $type3 && $line_1) {
                    $data->setField($phone);
                };
                if ($data->getType() == $type4 && $line_1) {
                    $data->setField($city);
                };
            }
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
    public function show(): Response
    {
        return $this->render('user/show_self.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
 }
