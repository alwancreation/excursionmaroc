<?php

namespace App\Services;

use App\Entity\ExcursionSchedule;
use App\Entity\MarketplaceBooking;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Crée les demandes de réservation marketplace. Le prix est TOUJOURS
 * recalculé ici à partir du produit/de la disponibilité en base — jamais
 * à partir d'une valeur envoyée par le client.
 */
class BookingService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @throws \InvalidArgumentException si les données ne permettent pas une réservation valide
     */
    public function createBookingRequest(
        Product $product,
        ?ExcursionSchedule $schedule,
        \DateTime $date,
        int $adults,
        int $children,
        string $customerName,
        string $customerPhone,
        string $customerEmail,
        ?string $comments,
        ?User $user
    ): MarketplaceBooking {
        $agency = $product->getAgency();
        if (!$agency) {
            throw new \InvalidArgumentException("Cette excursion n'a pas d'agence associée.");
        }

        $totalParticipants = $adults + $children;
        if ($totalParticipants < 1) {
            throw new \InvalidArgumentException('Au moins un participant est requis.');
        }

        if ($product->getMinPersons() && $totalParticipants < $product->getMinPersons()) {
            throw new \InvalidArgumentException('Le nombre de participants est inférieur au minimum requis pour cette excursion.');
        }

        if ($product->getMaxPersons() && $totalParticipants > $product->getMaxPersons()) {
            throw new \InvalidArgumentException('Le nombre de participants dépasse le maximum autorisé pour cette excursion.');
        }

        if ($schedule) {
            if ($schedule->getProduct() !== $product) {
                throw new \InvalidArgumentException("Cette disponibilité n'appartient pas à cette excursion.");
            }
            if ($schedule->isFull() || $schedule->getRemainingCapacity() < $totalParticipants) {
                throw new \InvalidArgumentException("Il ne reste pas assez de places disponibles pour cette date.");
            }
        }

        [$unitPrice, $totalPrice] = $this->calculatePrice($product, $schedule, $adults, $children);

        $booking = new MarketplaceBooking();
        $booking->setReference($this->generateReference());
        $booking->setUser($user);
        $booking->setProduct($product);
        $booking->setAgency($agency);
        $booking->setSchedule($schedule);
        $booking->setDate($schedule ? $schedule->getDate() : $date);
        $booking->setAdults($adults);
        $booking->setChildren($children);
        $booking->setTotalParticipants($totalParticipants);
        $booking->setUnitPrice($unitPrice);
        $booking->setTotalPrice($totalPrice);
        $booking->setCustomerName($customerName);
        $booking->setCustomerPhone($customerPhone);
        $booking->setCustomerEmail($customerEmail);
        $booking->setComments($comments);
        $booking->setStatus(MarketplaceBooking::STATUS_PENDING);

        if ($schedule) {
            // Reserve the spots pending the agency's decision; released again
            // by releaseCapacity() if the agency rejects the request.
            $schedule->setRemainingCapacity($schedule->getRemainingCapacity() - $totalParticipants);
            if ($schedule->getRemainingCapacity() <= 0) {
                $schedule->setStatus(ExcursionSchedule::STATUS_FULL);
            }
        }

        $this->em->persist($booking);
        $this->em->flush();

        return $booking;
    }

    /**
     * @return array{0: float, 1: float} [unitPrice, totalPrice]
     */
    public function calculatePrice(Product $product, ?ExcursionSchedule $schedule, int $adults, int $children): array
    {
        $unitPrice = ($schedule && $schedule->getPrice()) ? $schedule->getPrice() : (float) $product->getProductPrice();
        $totalPrice = $unitPrice * ($adults + $children);

        return [$unitPrice, $totalPrice];
    }

    private function generateReference(): string
    {
        $today = new \DateTime();
        $prefix = 'EXC-' . $today->format('Ymd') . '-';

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $count = (int) $this->em->createQueryBuilder()
                ->select('COUNT(b.id)')
                ->from(MarketplaceBooking::class, 'b')
                ->andWhere('b.reference LIKE :prefix')
                ->setParameter('prefix', $prefix . '%')
                ->getQuery()
                ->getSingleScalarResult();

            $candidate = $prefix . str_pad((string) ($count + 1 + $attempt), 4, '0', STR_PAD_LEFT);

            $exists = $this->em->getRepository(MarketplaceBooking::class)->findOneBy(['reference' => $candidate]);
            if (!$exists) {
                return $candidate;
            }
        }

        // Extremely unlikely fallback: fall back to a random suffix to guarantee uniqueness.
        return $prefix . substr(bin2hex(random_bytes(4)), 0, 4);
    }

    /**
     * @throws \InvalidArgumentException si la réservation n'est pas dans un état confirmable
     */
    public function confirm(MarketplaceBooking $booking): void
    {
        if ($booking->getStatus() !== MarketplaceBooking::STATUS_PENDING) {
            throw new \InvalidArgumentException('Seule une réservation en attente peut être confirmée.');
        }

        $booking->setStatus(MarketplaceBooking::STATUS_CONFIRMED);
        $this->em->flush();
    }

    /**
     * @throws \InvalidArgumentException si la réservation n'est pas dans un état rejetable
     */
    public function reject(MarketplaceBooking $booking): void
    {
        if ($booking->getStatus() !== MarketplaceBooking::STATUS_PENDING) {
            throw new \InvalidArgumentException('Seule une réservation en attente peut être refusée.');
        }

        $booking->setStatus(MarketplaceBooking::STATUS_REJECTED);
        $this->releaseCapacity($booking);
        $this->em->flush();
    }

    /**
     * Restitue les places réservées sur la disponibilité, s'il y en a une.
     */
    private function releaseCapacity(MarketplaceBooking $booking): void
    {
        $schedule = $booking->getSchedule();
        if (!$schedule) {
            return;
        }

        $schedule->setRemainingCapacity($schedule->getRemainingCapacity() + $booking->getTotalParticipants());
        if ($schedule->getStatus() === ExcursionSchedule::STATUS_FULL && $schedule->getRemainingCapacity() > 0) {
            $schedule->setStatus(ExcursionSchedule::STATUS_OPEN);
        }
    }
}
