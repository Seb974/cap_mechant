<?php

namespace App\Controller;

use Payplug;
use Payplug\Payment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaiementController extends AbstractController
{
    /**
     * @Route("/payment", name="payment")
     */
    public function index()
    {
		Payplug\Payplug::setSecretKey( $_ENV['PAYPLUG_KEY'] );
		$user     = $this->getUser();
		$metadata = $user ->getMetadata();
		$uniq_id  = uniqid( $user->getEmail(), true );

		$payment = \Payplug\Payment::create(array(
			'amount'         => 3680,
			'currency'       => 'EUR',
			'billing'          => array(
				'title'        => 'mr',
				'first_name'   => 'John',
				'last_name'    => 'Watson',
				'email'        => $user->getEmail(),
				'address1'     => '221B Baker Street',
				'postcode'     => 'NW16XE',
				'city'         => 'London',
				'country'      => 'fr',
				'language'     => 'fr'
			),
			'shipping'          => array(
				'title'         => 'mr',
				'first_name'    => 'John',
				'last_name'     => 'Watson',
				'email'         => $user->getEmail(),
				'address1'      => '221B Baker Street',
				'postcode'      => 'NW16XE',
				'city'          => 'London',
				'country'       => 'fr',
				'language'      => 'fr',
				'delivery_type' => 'BILLING'
			),
			'hosted_payment' => array(
				'return_url' => "http://localhost:8000/payment/success?{$uniq_id}",
				'cancel_url' => "http://localhost:8000/payment/fail?{$uniq_id}"
			),
			'notification_url' => "http://localhost:8000/payment/notif?{$uniq_id}"
		));

		$payment_url = $payment->hosted_payment->payment_url;
		$payment_id  = $payment->id;

        return $this->render('paiement/index.html.twig', [
			'payment_url' => $payment_url,
			'payment'     => $payment
        ]);
	}

	/**
     * @Route("/payment/success", name="payment_success")
     */
	public function payement_success(Request $request): Response {
		dd($request);
		return $this->render('paiement/index.html.twig', [
			'controller_name' => 'PaiementController',
			'payment_url' => 'toto'
        ]);
	}

	/**
     * @Route("/payment/fail", name="payment_fail")
     */
	public function payement_fail(Request $request): Response {
		dd($request);
		return $this->render('paiement/index.html.twig', [
			'controller_name' => 'PaiementController',
			'payment_url' => 'toto'
        ]);
	}

	/**
     * @Route("/payment/notif", name="payment_notif")
     */
	public function payement_notif(Request $request): Response {
		dd($request);
		return $this->render('paiement/index.html.twig', [
			'controller_name' => 'PaiementController',
			'payment_url' => 'toto'
        ]);
	}
}
