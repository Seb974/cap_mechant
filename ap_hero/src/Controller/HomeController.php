<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        if ($this->getUser()->getRoles()[0] !== "ROLE_ADMIN") {
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        } else {
            return $this->render('admin/index.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
    }
}