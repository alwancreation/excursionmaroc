<?php

namespace App\Security\Voter;

use App\Entity\Agency;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Garantit qu'une agence ne peut consulter/gérer que ses propres données
 * (via son appartenance UserAgency), sauf pour un administrateur.
 */
class AgencyVoter extends Voter
{
    public const VIEW = 'AGENCY_VIEW';
    public const MANAGE = 'AGENCY_MANAGE';

    protected function supports(string $attribute, $subject): bool
    {
        return \in_array($attribute, [self::VIEW, self::MANAGE], true) && $subject instanceof Agency;
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

        /** @var Agency $agency */
        $agency = $subject;
        foreach ($agency->getUsers() as $userAgency) {
            if ($userAgency->getUser() === $user) {
                return true;
            }
        }

        return false;
    }
}
