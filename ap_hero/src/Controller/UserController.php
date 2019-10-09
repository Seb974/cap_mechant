<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Metadata;
use App\Entity\Pics;

use App\Form\CreateUserType;
use App\Form\UpdateUserType;
use App\Repository\UserRepository;
use App\Repository\MetadataRepository;
use App\Service\Metadata\MetadataService;
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
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder, MetadataService $metadataService): Response
    {
        $user = new User();
        $form = $this->createForm(CreateUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $picFile = $form->get('picture')->getData();
            if ($picFile) {
                $picture = new Pics();
                $newFilename = $this->savePicture($picFile);
                $picture->setB64($newFilename);
                $user->setAvatar($picture);
            }

            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));
            //$this->updateMetadata($form, $user);
            $metadataService->createMetadata($form, $user);
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
    public function edit(Request $request, User $user, MetaDataService $metadataService): Response
    {
        $metadata = $user->getMetadata();
        $form = $this->createForm(UpdateUserType::class, $user);
        $metadataTab = [];

        foreach ($metadata as $data) {
            $field = $data->getField();
            $type = $data->getType();
            $metadataTab += [$type => $field];
        }
        if ($metadataTab != []) {
            $form->get('phone_number')->setData(intval($metadataTab['phone_number']));
            $form->get('delivery_line_1')->setData($metadataTab['delivery_line_1']);
            $form->get('delivery_line_2')->setData($metadataTab['delivery_line_2']);
            $form->get('delivery_city')->setData($metadataTab['delivery_city']);
            $form->get('billing_line_1')->setData($metadataTab['billing_line_1']);
            $form->get('billing_line_2')->setData($metadataTab['billing_line_2']);
            $form->get('billing_city')->setData($metadataTab['billing_city']);
        }
        $form->get('roles')->setData($this->convertRoleToField($user));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $picFile = $form->get('picture')->getData();
            if ($picFile) {
                $picture = new Pics();
                $newFilename = $this->savePicture($picFile);
                $picture->setB64($newFilename);
                $user->setAvatar($picture);
            }

            //$metadataTab == [] ? $this->createMetadata($form, $user) : $this->updateMetadata($form, $user);
            $metadataTab == [] ? $metadataService->createMetadata($form, $user) : $metadataService->updateMetadata($form, $user);
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

    // private function createMetadata($form, User $user)
    // {
    //     $phone = strval($form->get('phone_number')->getData());
    //     $billing_line_1 = $form->get('billing_line_1')->getData();
    //     $billing_line_2 = $form->get('billing_line_2')->getData();
    //     $billing_city = strval($form->get('billing_city')->getData()->getId());
    //     $type1 = 'phone_number';
    //     $type1_billing = 'billing_line_1';
    //     $type2_billing = 'billing_line_2';
    //     $type3_billing = 'billing_city';

    //     $delivery_line_1 = $form->get('delivery_line_1')->getData();
    //     $delivery_line_2 = $form->get('delivery_line_2')->getData();
    //     $delivery_city = strval($form->get('delivery_city')->getData()->getId());
    //     $type1_delivery = 'delivery_line_1';
    //     $type2_delivery = 'delivery_line_2';
    //     $type3_delivery = 'delivery_city';

    //     if ($phone) {
    //         $this->hydrateNewMetadata($phone, $type1, $user);
    //     }
    //     if ($billing_line_1) {
    //         $this->hydrateNewMetadata($billing_line_1, $type1_billing, $user);
    //     }
    //     if ($billing_line_2) {
    //         $this->hydrateNewMetadata($billing_line_2, $type2_billing, $user);
    //     } else {
    //         $this->hydrateNewMetadata('None', $type2_billing, $user);
    //     }
    //     if ($billing_city) {
    //         $this->hydrateNewMetadata($billing_city, $type3_billing, $user);
    //     }

    //     if ($delivery_line_1) {
    //         $this->hydrateNewMetadata($delivery_line_1, $type1_delivery, $user);
    //     }
    //     if ($delivery_line_2) {
    //         $this->hydrateNewMetadata($delivery_line_2, $type2_delivery, $user);
    //     } else {
    //         $this->hydrateNewMetadata('None', $type2_delivery, $user);
    //     }
    //     if ($delivery_city) {
    //         $this->hydrateNewMetadata($delivery_city, $type3_delivery, $user);
    //     }
    // }

    // private function updateMetadata($form, User $user)
    // {
    //     $phone = strval($form->get('phone_number')->getData());
    //     $delivery_line_1 = $form->get('delivery_line_1')->getData();
    //     $delivery_line_2 = $form->get('delivery_line_2')->getData();
    //     $delivery_city = strval($form->get('delivery_city')->getData()->getId());
    //     $type1 = 'phone_number';
    //     $type1_delivery = 'delivery_line_1';
    //     $type2_delivery = 'delivery_line_2';
    //     $type3_delivery = 'delivery_city';

    //     $billing_line_1 = $form->get('billing_line_1')->getData();
    //     $billing_line_2 = $form->get('billing_line_2')->getData();
    //     $billing_city = strval($form->get('billing_city')->getData()->getId());
    //     $type1_billing = 'billing_line_1';
    //     $type2_billing = 'billing_line_2';
    //     $type3_billing = 'billing_city';

    //         $metadata = $user->getMetadata()->unwrap();
    //         dump($phone);

    //         foreach ($metadata as $data) { 
                
    //             if ($data->getType() == $type1 && $phone) {
    //                 $data->setField($phone);
    //             };
    //             if ($data->getType() == $type1_delivery && $delivery_line_1) {
    //                 $data->setField($delivery_line_1);
    //             };
    //             if ($data->getType() == $type2_delivery && $delivery_line_2) {
    //                 $data->setField($delivery_line_2);
    //             } else if (!$delivery_line_2) {
    //                 $data->setField('None');
    //             };
    //             if ($data->getType() == $type3_delivery && $delivery_city) {
    //                 $data->setField($delivery_city);
    //             };

    //             if ($data->getType() == $type1_billing && $billing_line_1) {
    //                 $data->setField($billing_line_1);
    //             };
    //             if ($data->getType() == $type2_billing && $billing_line_2) {
    //                 $data->setField($billing_line_2);
    //             } else if (!$billing_line_2) {
    //                 $data->setField('None');
    //             };
    //             if ($data->getType() == $type3_billing && $billing_city) {
    //                 $data->setField($billing_city);
    //         };
    //         }
    // }

    // public function hydrateNewMetadata(String $field, String $type, User $user)
    // {
    //     $metadata = new Metadata();
    //     $metadata->setField($field);
    //     $metadata->setType($type);
    //     $entityManager = $this->getDoctrine()->getManager();
    //     $entityManager->persist($metadata);
    //     $user->addMetadata($metadata);
    //     $entityManager->flush();
    // }

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

    private function savePicture($pictureFile)
    {
        $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$pictureFile->guessExtension();

        try {
            $pictureFile->move(
                $this->getParameter('pics_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $newFilename;
    }
}
