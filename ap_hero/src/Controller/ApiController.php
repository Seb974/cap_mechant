<?php

namespace App\Controller;

use App\Security\FacebookAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\FacebookUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use League\OAuth2\Client\Token\AccessToken;

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
    public function callback( Request $request, ClientRegistry $clientRegistry ): Response
    {
		$parameters['code']  = $request->query->get("code");
		$parameters['state'] = $request->query->get("state");
		$accessToken         = new AccessToken( array( 'access_token' => $parameters['code'] ) );
		$facebookClient      = $clientRegistry->getClient('facebook');
		$facebookUser        = $facebookClient->fetchUserFromToken( $accessToken );

		// $parameters = array();
		// = = $facebookclient->fetchUserFromToken($accessToken);

        return $this->render('api/index.html.twig', [
			'controller_name' => 'ApiController',
			'request' => $facebookUser
        ]);
    }
}
