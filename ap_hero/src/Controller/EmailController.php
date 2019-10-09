<?php

namespace App\Controller;

use App\Entity\User;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use App\Controller\UserController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @Route("/email", name="email", methods={"GET"})
     */
    public function index(Request $request)
    {
        $circumstance = $request->get('user');
        if ($circumstance == "register") {

            $user = $this->getUser();

            $to      = [$user->getEmail()];
            $subject = "Welcome to ClikEat";
            $body    = "ok biche tu t'es register;\nYou need to confirm your address by clicking on the link below:\nhttps://www.clikeat.re/youhavejustregisteredandneedtoclikheretovalidateyouremailbitch/justdoit\nIf you didn't subscribe to a ClikEat account, just ignore this Email.\nThank You for your subscribtion\nLots of love <3 from the ClikEat team.";

        } else {

            $to      = [/* "yen.linkwang@nigao.re", "sebastien.maillot@coding-academy.fr", */"anne-marion.vitry@coding-academy.fr"];
            $subject = "Clikeat New Command";
            $body    = "not ok biche tu es dans else;\nA new command has been passed on ClikEat\nx30 burger saumon\nx05 Rhum Chatel Cahuète";
        }

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

<<<<<<< HEAD
        return $this->redirectToRoute('index');

=======
		return $this->redirectToRoute('index');
>>>>>>> 67d7e8b59415e557317e3dcc28de4e8eed44e169
    }
}
