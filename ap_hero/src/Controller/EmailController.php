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
        // Create the Transport
        $transport = (new Swift_SmtpTransport('clikeat.re', 25))
        ->setUsername('webmaster@clikeat.re')
        ->setPassword('Admin-Password-974')
        ;

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message('Une commande a été passée sur le site'))
        ->setFrom(['webmaster@clikeat.re' => 'Clik Eat'])
        ->setTo(['yen.linkwang@nigao.re' => 'Yen'])
        ->setBody('x30 burger')
        ;

        // Send the message
        $result = $mailer->send($message);

        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
        ]);
    }
}
