<?php

namespace App\Service;

use App\Entity\Offer;
use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(Offer $offer, User $receiver): void
    {
        $email = (new Email())
            ->from('flayesflayess@gmail.com')
            ->to($receiver->getEmail())
            ->subject('Your offer has been retained')
            ->html('<p>your offer:'.$offer->getTitle().' has been accepted by the project owner please checkout your account on flayes</p>');

        $this->mailer->send($email);
    }
}
