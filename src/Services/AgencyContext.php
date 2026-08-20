<?php

namespace App\Services;

use App\Entity\Agency;
use App\Entity\User;
use App\Entity\UserAgency;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Résout l'agence à laquelle appartient l'utilisateur connecté, à partir de
 * son appartenance UserAgency. Utilisé par tous les contrôleurs de l'espace
 * /agency pour ne jamais dépendre d'un identifiant d'agence passé en URL.
 */
class AgencyContext
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getCurrentAgency(User $user): ?Agency
    {
        $userAgency = $this->em->getRepository(UserAgency::class)->findOneBy(['user' => $user]);

        return $userAgency ? $userAgency->getAgency() : null;
    }
}
