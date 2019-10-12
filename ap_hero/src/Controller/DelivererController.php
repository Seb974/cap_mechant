<?php

namespace App\Controller;

use App\Entity\Orders;

use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_DELIVERER")
 */
class DelivererController extends AbstractController
{
    /**
     * @Route("/deliverer", name="deliverer")
     */
    public function index(OrderRepository $orderRepository, UserRepository $userRepository)
    {
		$del_order = $orderRepository->findAll();
		dump($del_order);

        return $this->render('deliverer/index.html.twig', [
			'del_order' => $del_order,
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
