<?php

namespace App\Controller;

use App\Entity\Orders;
use Doctrine\ORM\EntityManagerInterface;
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
    public function cronUpdate( EntityManagerInterface $em )
    {
		$now = new \DateTime();
		$orders = $em->getRepository( Orders::class )->findAll();
		foreach ($orders as $key => $order) {
			$orderPayedTime = $order->getPayDateTime();

			$supplierTimer_hr = $order->getSupplier()->getPreparationPeriod()->format('H');
			$supplierTimer_mn = $order->getSupplier()->getPreparationPeriod()->format('i');
			$timer = new \DateInterval( "PT{$supplierTimer_hr}H{$supplierTimer_mn}M" );
			dump( $orderPayedTime->add( $timer ));
		}

        return $this->render('deliverer/index.html.twig', [
			'controller_name' => 'DelivererController',
        ]);
    }
}
