<?php

namespace App\Repository;

use App\Entity\ExcursionItinerary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExcursionItinerary|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExcursionItinerary|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExcursionItinerary[]    findAll()
 * @method ExcursionItinerary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExcursionItineraryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExcursionItinerary::class);
    }
}
