<?php

namespace App\Security\Voter;

use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Garantit qu'une agence ne peut consulter/gérer que ses propres excursions,
 * sauf pour un administrateur.
 */
class ExcursionVoter extends Voter
{
    public const VIEW = 'EXCURSION_VIEW';
    public const MANAGE = 'EXCURSION_MANAGE';

    protected function supports(string $attribute, $subject): bool
    {
        return \in_array($attribute, [self::VIEW, self::MANAGE], true) && $subject instanceof Product;
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

        /** @var Product $product */
        $product = $subject;
        $agency = $product->getAgency();
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
