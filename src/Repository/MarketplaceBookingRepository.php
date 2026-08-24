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
}
