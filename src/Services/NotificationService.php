<?php

namespace App\Services;

use App\Entity\MarketplaceBooking;
use App\Entity\Product;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

/**
 * Envoie les emails transactionnels liés aux réservations marketplace.
 * Un échec d'envoi (SMTP indisponible, DSN absent...) est journalisé
 * mais ne doit jamais faire échouer l'action métier associée.
 */
class NotificationService
{
    private MailerInterface $mailer;
    private Environment $twig;
    private ApplicationSettings $settings;
    private LoggerInterface $logger;

    public function __construct(MailerInterface $mailer, Environment $twig, ApplicationSettings $settings, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->settings = $settings;
        $this->logger = $logger;
    }

    public function notifyAgencyNewBooking(MarketplaceBooking $booking): void
    {
        $agency = $booking->getAgency();
        if (!$agency || !$agency->getEmail()) {
            return;
        }

        $this->send(
            $agency->getEmail(),
            sprintf('Nouvelle demande de réservation — %s', $booking->getReference()),
            'emails/booking_new_agency.html.twig',
            ['booking' => $booking]
        );
    }

    public function notifyClientBookingReceived(MarketplaceBooking $booking): void
    {
        if (!$booking->getCustomerEmail()) {
            return;
        }

        $this->send(
            $booking->getCustomerEmail(),
            sprintf('Votre demande de réservation %s a bien été reçue', $booking->getReference()),
            'emails/booking_received.html.twig',
            ['booking' => $booking]
        );
    }

    public function notifyClientBookingConfirmed(MarketplaceBooking $booking): void
    {
        if (!$booking->getCustomerEmail()) {
            return;
        }

        $this->send(
            $booking->getCustomerEmail(),
            sprintf('Réservation confirmée — %s', $booking->getReference()),
            'emails/booking_confirmed.html.twig',
            ['booking' => $booking]
        );
    }

    public function notifyClientBookingRejected(MarketplaceBooking $booking): void
    {
        if (!$booking->getCustomerEmail()) {
            return;
        }

        $this->send(
            $booking->getCustomerEmail(),
            sprintf('Réservation refusée — %s', $booking->getReference()),
            'emails/booking_rejected.html.twig',
            ['booking' => $booking]
        );
    }

    public function notifyAgencyExcursionApproved(Product $product): void
    {
        $agency = $product->getAgency();
        if (!$agency || !$agency->getEmail()) {
            return;
        }

        $this->send(
            $agency->getEmail(),
            sprintf('Votre excursion "%s" a été publiée', $product->getProductName()),
            'emails/excursion_approved.html.twig',
            ['product' => $product]
        );
    }

    public function notifyAgencyExcursionRejected(Product $product): void
    {
        $agency = $product->getAgency();
        if (!$agency || !$agency->getEmail()) {
            return;
        }

        $this->send(
            $agency->getEmail(),
            sprintf('Votre excursion "%s" nécessite des modifications', $product->getProductName()),
            'emails/excursion_rejected.html.twig',
            ['product' => $product]
        );
    }

    public function notifyAgencyAccountApproved(\App\Entity\Agency $agency): void
    {
        if (!$agency->getEmail()) {
            return;
        }

        $this->send(
            $agency->getEmail(),
            'Votre agence a été validée',
            'emails/agency_approved.html.twig',
            ['agency' => $agency]
        );
    }

    private function send(string $to, string $subject, string $template, array $context): void
    {
        try {
            $html = $this->twig->render($template, $context);
            $email = (new Email())
                ->from($this->settings->application_email ?: 'no-reply@excursionmaroc.com')
                ->to($to)
                ->subject($subject)
                ->html($html);

            $this->mailer->send($email);
        } catch (\Throwable $e) {
            $this->logger->error('Echec envoi email de notification: ' . $e->getMessage(), ['to' => $to, 'template' => $template]);
        }
    }
}
