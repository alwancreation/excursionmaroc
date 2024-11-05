<?php

namespace App\Repository;
use App\Entity\User;
use App\Entity\UserAgency;
use App\Entity\VehiclePrice;
use Doctrine\ORM\EntityRepository;

/**
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AgencyRepository extends EntityRepository
{
    public function findAllGranted(User $user,$returnQuery = false)
    {
        if ($user->hasRole('ROLE_ADMIN')){
            $q = $this->createQueryBuilder('a')
                ;
            if ($returnQuery){
                return $q;
            }
            return $q->getQuery()->getResult();
        }

        $q = $this->createQueryBuilder('a')
            ->join("a.users","uc")
            ->where('uc.user = :user')
            ->andWhere('uc.agency = a')
            ->setParameter('user', $user)
            ;
        if ($returnQuery){
            return $q;
        }
        return $q->getQuery()->getResult();
    }
}