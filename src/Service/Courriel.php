<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Courriel
{
    private MailerInterface $mailer;
    //pour injecter un services dans un service => constructeur
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function envoi($mail, $sujet, $corps, $emailMoi){
        $email = (new Email())
            ->from($emailMoi)
            ->subject($sujet)
            ->to($mail)
            -> text($corps);
        $this->mailer->send($email);
    }
}