<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DelivererController extends AbstractController
{
    /**
     * @Route("/deliverer", name="deliverer")
     */
    public function index()
    {
        return $this->render('deliverer/index.html.twig', [
            'controller_name' => 'DelivererController',
        ]);
	}

	/**
     * @Route("/deliverer/cron", name="deliverer_cron")
     */
    public function cronUpdate()
    {
        return $this->render('deliverer/index.html.twig', [
            'controller_name' => 'DelivererController',
        ]);
    }
}
