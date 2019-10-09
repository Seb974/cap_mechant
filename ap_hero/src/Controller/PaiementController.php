<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Service\Cart\CartService;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Payplug;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaiementController extends AbstractController
{
    /**
     * @Route("/checkout", name="checkout")
     */
    public function checkout( CartService $cartService, EntityManagerInterface $em )
    {
		Payplug\Payplug::setSecretKey( $_ENV['PAYPLUG_KEY'] );
		$user     = $this->getUser();
		// $metadata = $user ->getMetadata();
		$uniq_id  = uniqid( $user->getEmail() );

		$payment = \Payplug\Payment::create(array(
			'amount'   => 3680 ,
			'currency' => 'EUR',
			'billing'        => array(
				'title'      => 'mr'               ,
				'first_name' => 'John'             ,
				'last_name'  => 'Watson'           ,
				'email'      => $user->getEmail()  ,
				'address1'   => '221B Baker Street',
				'postcode'   => 'NW16XE'           ,
				'city'       => 'London'           ,
				'country'    => 'FR'               ,
				'language'   => 'fr'
			),

			'shipping'          => array(
				'title'         => 'mr'               ,
				'first_name'    => 'John'             ,
				'last_name'     => 'Watson'           ,
				'email'         => $user->getEmail()  ,
				'address1'      => '221B Baker Street',
				'postcode'      => 'NW16XE'           ,
				'city'          => 'London'           ,
				'country'       => 'FR'               ,
				'language'      => 'fr'               ,
				'delivery_type' => 'BILLING'
			),

			'hosted_payment' => array(
				'return_url' => "http://localhost:8000/payment/success?{$uniq_id}",
				'cancel_url' => "http://localhost:8000/payment/fail?{$uniq_id}"
			),

			'notification_url' => "https://exemple/payment/notif?{$uniq_id}"
		));

		$OneCartItem = $user->getCart()->getCartItems()[0];
		$payment_url = $payment->hosted_payment->payment_url;
		$payment_id  = $payment->id;
		$itemOrder_exist = $em->getRepository( Orders::class )->findOneBy( [ 'cartItem' => $OneCartItem ] );
		if ( !$itemOrder_exist ) {
			$cartService->convertCartToOrders( $user->getCart(), $uniq_id, $payment_id, 'payplug' );
		} else {
			foreach ( $user->getCart()->getCartItems() as $key => $value ) {
				$item = $em->getRepository( Orders::class )->findOneBy( [ 'cartItem' => $value ] );
				$item->setPaymentId( $payment_id );
				$item->setInternalId( $uniq_id );
				$em->flush();
			}
		};

        return $this->render('paiement/checkout.html.twig', [
			'payment_url' => $payment_url,
			'payment'     => $payment,
			'cart'		  => $user->getCart(),
        ]);
	}

	/**
     * @Route("/payment/success", name="payment_success")
     */
	public function payement_success( Request $request ): Response {
		return $this->render('paiement/success.html.twig', [
			'request' => $request
        ]);
	}

	/**
     * @Route("/payment/fail", name="payment_fail")
     */
	public function payement_fail(Request $request): Response {
		return $this->render('paiement/fail.html.twig', [
			'request' => $request
        ]);
	}

	/**
     * @Route("/payment/notif", name="payment_notif")
     */
	public function payement_notif(Request $request): Response {
		return $this->render('paiement/notif.html.twig', [
			'request' => $request
        ]);
	}
}
