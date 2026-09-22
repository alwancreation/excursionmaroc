<?php

namespace App\Repository;

use App\Entity\MarketplaceBooking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MarketplaceBooking|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarketplaceBooking|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarketplaceBooking[]    findAll()
 * @method MarketplaceBooking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarketplaceBookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarketplaceBooking::class);
    }

    /**
     * @return MarketplaceBooking[]
     */
    public function findForAgency(\App\Entity\Agency $agency, ?string $status = null): array
    {
        $qb = $this->createQueryBuilder('b')
            ->addSelect('p')
            ->innerJoin('b.product', 'p')
            ->andWhere('b.agency = :agency')
            ->setParameter('agency', $agency)
            ->orderBy('b.dateCreate', 'DESC');

        if ($status) {
            $qb->andWhere('b.status = :status')->setParameter('status', $status);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @return MarketplaceBooking[]
     */
    public function findForUser(\App\Entity\User $user): array
    {
        return $this->createQueryBuilder('b')
            ->addSelect('p')
            ->addSelect('c')
            ->innerJoin('b.product', 'p')
            ->leftJoin('p.category', 'c')
            ->andWhere('b.user = :user')
            ->setParameter('user', $user)
            ->orderBy('b.dateCreate', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
