<?php

namespace App\Controller;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @Route("/email", name="email")
     */
    public function index()
    {

        $to      = [ "yen.linkwang@nigao.re", "sebastien.maillot@coding-academy.fr", "anne-marion.vitry@coding-academy.fr" ];
        $subject = "Clikeat New Command";
        $body    = "A new command has been passed on ClikEat\nx30 burger saumon\nx05 Rhum Chatel Cahuète";

        // Create the Transport
        $transport = (new Swift_SmtpTransport( $_ENV['MAILER_SMTP'], 25 ) )
            ->setUsername( $_ENV['MAILER_USERNAME'] )
            ->setPassword( $_ENV['MAILER_PASSWORD'] )
        ;

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer( $transport );

        // Create a message
        $message = ( new Swift_Message( $subject ) )
            ->setFrom( [ $_ENV['MAILER_USERNAME'] => 'ClikEat' ] )
            ->setTo( $to )
            ->setBody( $body )
        ;

        // Send the message
        $result = $mailer->send( $message );

        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
        ]);
    }
}
