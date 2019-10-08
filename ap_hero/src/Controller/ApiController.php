<?php

namespace App\Controller;

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
    public function callback( Request $request ): Response
    {
        return $this->render('api/index.html.twig', [
			'controller_name' => 'ApiController',
			'request' => $request
        ]);
    }
}
