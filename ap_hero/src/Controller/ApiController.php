<?php

namespace App\Controller;

use App\Security\FacebookAuthenticator;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\FacebookUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
	}

	/**
     * @Route("/api/callback", name="api_callback")
     */
    public function callback( Request $request, ClientRegistry $clientRegistry, EntityManagerInterface $em, UserManagerInterface $userManager ): Response
    {
		// $parameters[] = $request->query->get("code");
		// $parameters = array();
		// = = $facebookclient->fetchUserFromToken($token);

        return $this->render('api/index.html.twig', [
			'controller_name' => 'ApiController',
			'request' => 'toto'
        ]);
    }
}
