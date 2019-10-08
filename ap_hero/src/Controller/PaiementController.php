<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Payplug\Payment;
use Payplug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PaiementController extends AbstractController
{
    /**
     * @Route("/payment", name="payment")
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
				'return_url' => 'http://localhost:8000/payment/success',
				'cancel_url' => 'http://localhost:8000/payment/fail'
			),
			'notification_url' => 'http://localhost:8000/payment/notif'
		));

		$payment_url = $payment->hosted_payment->payment_url;
		$payment_id  = $payment->id;

		$payment->hosted_payment->return_url = "http://localhost:8000/payment/success?{$payment_id}";
		$payment->hosted_payment->cancel_url = "http://localhost:8000/payment/fail?{$payment_id}"   ;
		$payment->hosted_payment->cancel_url = "http://localhost:8000/payment/notif?{$payment_id}"  ;

		$my_payment = $payment;
        return $this->render('paiement/index.html.twig', [
			'payment_url' => $payment_url,
			'payment'     => $my_payment
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
