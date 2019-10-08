<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\FacebookUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

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
		$facebookclient = $clientRegistry->getClient('facebook');
		$facebookUser   = new FacebookUser( $request->query );
		// $parameters[] = $request->query->get("code");
		// $parameters = array();
		// = = $facebookclient->fetchUserFromToken($token);

        return $this->render('api/index.html.twig', [
			'controller_name' => 'ApiController',
			'request' => $facebookUser
        ]);
    }
}
