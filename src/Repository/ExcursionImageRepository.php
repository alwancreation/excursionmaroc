<?php

namespace App\Repository;

use App\Entity\ExcursionImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExcursionImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExcursionImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExcursionImage[]    findAll()
 * @method ExcursionImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExcursionImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExcursionImage::class);
    }
}
