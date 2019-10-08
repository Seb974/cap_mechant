<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order")
 */
class OrderController extends AbstractController
{ 
    /**
     * @Route("/preparations", name="get_order", methods={"GET"})
     */
    public function getOrdersToPrepare(OrderRepository $orderRepository)
    {
        $user = $this->getUser();
        $greaterRole = (in_array('ROLE_ADMIN', $user->getRoles())) ? 'ROLE_ADMIN' : 'ROLE_SUPPLIER';
        if ($greaterRole === 'ROLE_ADMIN') {
            $orders = $orderRepository->findBy(['orderStatus' => 'ON_PREPARE']);
        } 
        else {
            if ( $user->getSupplier() ) {
                $orders = $orderRepository->findBy(['orderStatus' => 'ON_PREPARE', 'supplier' => $user->getSupplier()]);
            } else {
                $orders =  new orders();
            }
        }
        return $this->render('order/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    /**
     * @Route("/deliveries", name="get_deliveries", methods={"GET"})
     */
    public function getOrdersToDeliver(OrderRepository $orderRepository)
    {
        $user = $this->getUser();
        $orders = $orderRepository->findBy(['orderStatus' => 'ON_DELIVERY']);

        return $this->render('order/index.html.twig', [
            'orders' => $orders,
        ]);
    }
}