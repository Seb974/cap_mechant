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

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
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
        if ($metadata) {
            $form->get('phone_number')->setData($metadata->getPhoneNumber());
            $form->get('facturation_address')->setData($metadata->getFacturationAddress());
            $form->get('delivery_address')->setData($metadata->getDeliveryAddress());
            $form->get('city')->setData($metadata->getCity());
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
        
        if ($facturation && $delivery && $phone) {
            //$entityManager = $this->getDoctrine()->getManager();
            $metadata->setFacturationAddress($facturation);
            $metadata->setDeliveryAddress($delivery);
            $metadata->setPhoneNumber($phone);
            $metadata->setCity($city);
            return $metadata;
        }
        return null;
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
