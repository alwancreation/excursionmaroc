<?php

namespace App\Security\Voter;

use App\Entity\Review;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Garantit qu'une agence ne peut répondre qu'aux avis laissés sur ses
 * propres excursions, sauf pour un administrateur.
 */
class ReviewVoter extends Voter
{
    public const MANAGE = 'REVIEW_MANAGE';

    protected function supports(string $attribute, $subject): bool
    {
        return self::MANAGE === $attribute && $subject instanceof Review;
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

        /** @var Review $review */
        $review = $subject;
        $agency = $review->getAgency();
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
