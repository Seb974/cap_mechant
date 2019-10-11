<?php

namespace App\Controller;

use App\Entity\Orders;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DelivererController extends AbstractController
{
    /**
     * @Route("/deliverer", name="deliverer")
     */
    public function index(UserRepository $userRepository)
    {
		$user = $this->getUser();
		$deliverers = [];
        foreach ($userRepository->findAll() as $del) {
            $deliverRole = (in_array('ROLE_DELIVERER', $del->getRoles())) ? 'ROLE_DELIVERER' : false;
            if ($deliverRole) {
                array_push($deliverers, $del);
			}
			dump($deliverers);
        }

        // if ($deliverer === 'ROLE_ADMIN') {
        //     return $this->render('stock/index.html.twig', [
        //         'stocks' => $allStock,
        //     ]);
        // }

        return $this->render('deliverer/index.html.twig', [
            'deliverers' => $deliverers,
        ]);
    }

    /**
     * @Route("/deliverer/cron", name="deliverer_cron")
     */
    public function cronUpdate( EntityManagerInterface $em )
    {
        $now = new \DateTime();
        $orders = $em->getRepository( Orders::class )->findAll();
        $answer = "no orders";
        foreach ($orders as $key => $order) {
            $orderPayedTime = $order->getPayDateTime();

            $supplierTimer_hr = $order->getSupplier()->getPreparationPeriod()->format('H');
            $supplierTimer_mn = $order->getSupplier()->getPreparationPeriod()->format('i');
            $timer = new \DateInterval( "PT{$supplierTimer_hr}H{$supplierTimer_mn}M" );
            $checkDelay = $orderPayedTime->add( $timer );
            if ( $checkDelay > $now ) {
                $answer = "allez livrer";
            } else {
                $answer = "reste la case";
            }
        }

        return $this->render('deliverer/index.html.twig', [
            'controller_name' => 'DelivererController',
            'answer' => $answer
        ]);
    }
}
