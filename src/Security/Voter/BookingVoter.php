<?php

namespace App\Security\Voter;

use App\Entity\MarketplaceBooking;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Garantit qu'une agence ne peut consulter/gerer que les reservations
 * faites sur ses propres excursions, sauf pour un administrateur.
 */
class BookingVoter extends Voter
{
    public const VIEW = 'BOOKING_VIEW';
    public const MANAGE = 'BOOKING_MANAGE';

    protected function supports(string $attribute, $subject): bool
    {
        return \in_array($attribute, [self::VIEW, self::MANAGE], true) && $subject instanceof MarketplaceBooking;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        if (\in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return true;
        }

        /** @var MarketplaceBooking $booking */
        $booking = $subject;
        $agency = $booking->getAgency();
        if (!$agency) {
            return false;
        }

        foreach ($agency->getUsers() as $userAgency) {
            if ($userAgency->getUser() === $user) {
                return true;
            }
        }

        return false;
    }
}
