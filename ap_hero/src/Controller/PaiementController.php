<?php

namespace App\Controller;

use App\Entity\CartItem as CartItem;
use App\Entity\Metadata;
use App\Entity\User;
use App\Entity\City;
use App\Entity\Orders;
use App\Service\Anonymize\AnonymizeService;
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
     * @Route("/checkout/{id}", name="checkout")
     */
    public function checkout($id, CartService $cartService, EntityManagerInterface $em )
    {
		Payplug\Payplug::setSecretKey( $_ENV['PAYPLUG_KEY'] );
		$user = $em->getRepository( User::class )->find( $id );
		$cart = $user->getCart();
		$uniq_id  = uniqid( $user->getEmail() );

		$payment = \Payplug\Payment::create(array(
			'amount'   => $cart->getTotalToPay() * 100,
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
				'return_url' => "{$_ENV['SERVER_URL']}/payment/success/{$id}?id={$uniq_id}",
				'cancel_url' => "{$_ENV['SERVER_URL']}/payment/fail?id={$uniq_id}"
		),

			'notification_url' => "{$_ENV['SERVER_URL']}/payment/notif?id={$uniq_id}"
		));

		$cartItems = $user->getCart()->getCartItems();
		foreach ( $cartItems as $key => $value ) {
			if ( $value->getIsPaid() === false ) {
				$OneCartItem = $value;
			}
		}

		$payment_url     = $payment->hosted_payment->payment_url;
		$payment_id      = $payment->id;
		$itemOrder_exist = $em->getRepository( Orders::class )->findOneBy( [ 'cartItem' => $OneCartItem ] );
		$count           = 0;

		if ( ! $itemOrder_exist ) {
			$cartService->convertCartToOrders( $user->getCart(), $uniq_id, $payment_id, 'payplug' );
		} else {
			// Abort old payment
			$old_payplug_id = $itemOrder_exist->getPaymentId();
			if ( 1 === 3 ) {
				$payment = \Payplug\Payment::abort( $old_payplug_id );
			}

			// Update Internal & External ID of new Payment
			foreach ( $user->getCart()->getCartItems() as $key => $value ) {
				if ( ! $value->getIsPaid() ) {
					$item = $em->getRepository( Orders::class )->findOneBy( [ 'cartItem' => $value ] );
					$item->setPaymentId( $payment_id );
					$item->setInternalId( $uniq_id );
					$em->flush();
					$count++;
				}
			}
		};

		$billing_city  = $em->getRepository( Metadata::class )->findOneBy( [ 'user' => $user, 'type' => 'billing_city'  ] );
		$delivery_city = $em->getRepository( Metadata::class )->findOneBy( [ 'user' => $user, 'type' => 'delivery_city' ] );

		$metas['billing1'      ] = $em->getRepository( Metadata::class )->findOneBy( [ 'user' => $user, 'type' => 'billing_line_1' ] );
		$metas['billing2'      ] = $em->getRepository( Metadata::class )->findOneBy( [ 'user' => $user, 'type' => 'billing_line_2' ] );
		$metas['billing_city'  ] = $em->getRepository( City    ::class )->find( $billing_city );

		$metas['delivery1'     ] = $em->getRepository( Metadata ::class )->findOneBy( [ 'user' => $user , 'type' => 'delivery_line_1' ] );
		$metas['delivery2'     ] = $em->getRepository( Metadata ::class )->findOneBy( [ 'user' => $user , 'type' => 'delivery_line_2' ] );
		$metas['delivery_city' ] = $em->getRepository( City     ::class )->find( $delivery_city );

		$metas['phone'         ] = $em->getRepository( Metadata::class )->findOneBy( [ 'user' => $user, 'type' => 'phone_number' ] );

        return $this->render('paiement/checkout.html.twig', [
			'payment_url' => $payment_url,
			'payment'     => $payment,
			'cart'		  => $user->getCart(),
			'user' 		  => $user,
			'count'		  => $count,
			'metas'       => $metas
        ]);
	}

	/**
     * @Route("/payment/success/{id}", name="payment_success")
     */
	public function payement_success($id, Request $request, CartService $cartService, AnonymizeService $anonymizeService, EntityManagerInterface $em ): Response {

		$uniq_id = $request->query->get('id');
		$orders  = $em->getRepository( Orders::class )->findBy( [ 'internalId' => $uniq_id ] );
		$user    = $em->getRepository( User::class   )->find( $id );
		$cart    = $user->getCart();

		foreach ( $orders as $key => $order ) {
			$order->setOrderStatus('ON_PREPARE');
			$order->setPayDateTime( new \DateTime() );
			$em->flush();
		}
		$cartService->decreaseStock($cart);
		$cartService->initCart($cart);
		if (in_array('ROLE_GUEST', $user->getRoles())) {
			$anonymizeService->anonymize($user);
		}
		return $this->redirectToRoute('index');
	}

	/**
     * @Route("/payment/fail", name="payment_fail")
     */
	public function payement_fail( Request $request, EntityManagerInterface $em ): Response {
		$uniq_id = $request->query->get('id');
		$orders  = $em->getRepository( Orders::class )->findBy( [ 'internalId' => $uniq_id ] );

		foreach ( $orders as $key => $order ) {
			$order->setOrderStatus('FAILED');
			$em->flush();
		}

		return $this->redirectToRoute('index');
	}

	/**
     * @Route("/payment/notif", name="payment_notif")
     */
	public function payement_notif( Request $request ): Response {
		return $this->render('paiement/notif.html.twig', [
			'request' => $request
        ]);
	}
}
