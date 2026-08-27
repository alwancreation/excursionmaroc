<?php

namespace App\Repository;

use App\Entity\ExcursionSchedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExcursionSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExcursionSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExcursionSchedule[]    findAll()
 * @method ExcursionSchedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExcursionScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExcursionSchedule::class);
    }
}
