<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Metadata;
use App\Form\EditSelfType;
use App\Controller\UserController;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use App\Service\Cart\CartService;
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

            $picFile = $form->get('picture')->getData();
            if ($picFile) {
                $picture = new Pics();
                $newFilename = $this->savePicture($picFile);
                $picture->setB64($newFilename);
                $user->setAvatar($picture);
            }

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
            $form->get('delivery_line_1')->setData($metadataTab['delivery_line_1']);
            $form->get('delivery_line_2')->setData($metadataTab['delivery_line_2']);
            $form->get('delivery_city')->setData($metadataTab['delivery_city']);

            $form->get('billing_line_1')->setData($metadataTab['billing_line_1']);
            $form->get('billing_line_2')->setData($metadataTab['billing_line_2']);
            $form->get('billing_city')->setData($metadataTab['billing_city']);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $metadataTab != [] ? $this->updateMetadata($form, $user) : $this->createMetadata($form, $user);

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
        $phone = strval($form->get('phone_number')->getData());
        $billing_line_1 = $form->get('billing_line_1')->getData();
        $billing_line_2 = $form->get('billing_line_2')->getData();
        $billing_city = strval($form->get('billing_city')->getData()->getId());
        $type1 = 'phone_number';
        $type1_billing = 'billing_line_1';
        $type2_billing = 'billing_line_2';
        $type4_billing = 'billing_city';

        $delivery_line_1 = $form->get('delivery_line_1')->getData();
        $delivery_line_2 = $form->get('delivery_line_2')->getData();
        $delivery_city = strval($form->get('delivery_city')->getData()->getId());
        $type1_delivery = 'delivery_line_1';
        $type2_delivery = 'delivery_line_2';
        $type4_delivery = 'delivery_city';

        if ($phone) {
            $this->hydrateNewMetadata($phone, $type1, $user);
        }
        if ($billing_line_1) {
            $this->hydrateNewMetadata($billing_line_1, $type1_billing, $user);
        }
        if ($billing_line_2) {
            $this->hydrateNewMetadata($billing_line_2, $type2_billing, $user);
        }
        if ($billing_city) {
            $this->hydrateNewMetadata($billing_city, $type4_billing, $user);
        }

        if ($delivery_line_1) {
            $this->hydrateNewMetadata($delivery_line_1, $type1_delivery, $user);
        }
        if ($delivery_line_2) {
            $this->hydrateNewMetadata($delivery_line_2, $type2_delivery, $user);
        }
        if ($delivery_city) {
            $this->hydrateNewMetadata($delivery_city, $type4_delivery, $user);
        }
    }

    private function updateMetadata($form, User $user)
    {
        $phone = strval($form->get('phone_number')->getData());
        $delivery_line_1 = $form->get('delivery_line_1')->getData();
        $delivery_line_2 = $form->get('delivery_line_2')->getData();
        $delivery_city = strval($form->get('delivery_city')->getData()->getId());
        $type1 = 'phone_number';
        $type1_delivery = 'delivery_line_1';
        $type2_delivery = 'delivery_line_2';
        $type4_delivery = 'delivery_city';

        $billing_line_1 = $form->get('billing_line_1')->getData();
        $billing_line_2 = $form->get('billing_line_2')->getData();
        $billing_city = strval($form->get('billing_city')->getData()->getId());
        $type1_billing = 'billing_line_1';
        $type2_billing = 'billing_line_2';
        $type4_billing = 'billing_city';

            $metadata = $user->getMetadata()->unwrap();

            foreach ($metadata as $data) { 
                if ($data->getType() == $type1 && $phone) {
                    $data->setField($phone);
                };
                if ($data->getType() == $type1_delivery && $delivery_line_1) {
                    $data->setField($delivery_line_1);
                };
                if ($data->getType() == $type2_delivery && $delivery_line_2) {
                    $data->setField($delivery_line_2);
                }
                if ($data->getType() == $type4_delivery && $delivery_city) {
                    $data->setField($delivery_city);
                };

                if ($data->getType() == $type1_billing && $billing_line_1) {
                    $data->setField($billing_line_1);
                };
                if ($data->getType() == $type2_billing && $billing_line_2) {
                    $data->setField($billing_line_2);
                }
                if ($data->getType() == $type4_billing && $billing_city) {
                    $data->setField($billing_city);
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
