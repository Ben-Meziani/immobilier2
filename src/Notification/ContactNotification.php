<?php
namespace App\Notification;

use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;
use Symfony\Component\Mime\Email;


class ContactNotification {

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(MailerInterface $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify() {
        $message = (new Email())
                ->from('no-reply@interim.fr')
                ->to('contact@agence.fr')
                ->html(
                    "Bonjour,<br><br>Une demande de réinitialisation de mot de passe a été effectuée pour le site Nouvelle-Techno.fr. Veuillez cliquer sur le lien suivant : " . $url,
                    'text/html'
                )
            ;
        $this->mailer->send($message);
    }

}
