<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Payplug\Payment;
use Payplug;

class PaiementController extends AbstractController
{
    /**
     * @Route("/paiement", name="paiement")
     */
    public function index()
    {
		Payplug\Payplug::setSecretKey( $_ENV['PAYPLUG_KEY'] );

		$email      = 'john.watson@example.net';
		$first_name = 'John'                   ;
		$last_name  = 'Watson'                 ;

		$payment = \Payplug\Payment::create(array(
			'amount'         => 3680,
			'currency'       => 'EUR',
			'billing'          => array(
				'title'        => 'mr',
				'first_name'   => 'John',
				'last_name'    => 'Watson',
				'email'        => 'john.watson@example.net',
				'address1'     => '221B Baker Street',
				'postcode'     => 'NW16XE',
				'city'         => 'London',
				'country'      => 'GB',
				'language'     => 'en'
			),
			'shipping'          => array(
				'title'         => 'mr',
				'first_name'    => 'John',
				'last_name'     => 'Watson',
				'email'         => 'john.watson@example.net',
				'address1'      => '221B Baker Street',
				'postcode'      => 'NW16XE',
				'city'          => 'London',
				'country'       => 'GB',
				'language'      => 'en',
				'delivery_type' => 'BILLING'
			),
			'hosted_payment' => array(
				'return_url' => 'https://example.net/success',
				'cancel_url' => 'https://example.net/cancel'
			),
			'notification_url' => 'https://example.net/notifications'
		));

		$payment_url = $payment->hosted_payment->payment_url;
		$payment_id = $payment->id;
		dump($payment_url);

        return $this->render('paiement/index.html.twig', [
			'controller_name' => 'PaiementController',
			'payment_url' => $payment_url
        ]);
    }
}
