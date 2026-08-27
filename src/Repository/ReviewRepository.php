<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function getAverageRating(\App\Entity\Product $product): ?float
    {
        $result = $this->createQueryBuilder('r')
            ->select('AVG(r.rating) as avgRating')
            ->andWhere('r.product = :product')
            ->andWhere('r.status = :status')
            ->setParameter('product', $product)
            ->setParameter('status', Review::STATUS_PUBLISHED)
            ->getQuery()
            ->getSingleScalarResult();

        return $result !== null ? (float) $result : null;
    }

    /**
     * @return Review[]
     */
    public function findPublishedForProduct(\App\Entity\Product $product): array
    {
        return $this->createQueryBuilder('r')
            ->addSelect('u')
            ->innerJoin('r.user', 'u')
            ->andWhere('r.product = :product')
            ->andWhere('r.status = :status')
            ->setParameter('product', $product)
            ->setParameter('status', Review::STATUS_PUBLISHED)
            ->orderBy('r.dateCreate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Review[]
     */
    public function findForAgency(\App\Entity\Agency $agency): array
    {
        return $this->createQueryBuilder('r')
            ->addSelect('p')
            ->addSelect('u')
            ->innerJoin('r.product', 'p')
            ->innerJoin('r.user', 'u')
            ->andWhere('r.agency = :agency')
            ->setParameter('agency', $agency)
            ->orderBy('r.dateCreate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Review[]
     */
    public function findAllWithRelations(): array
    {
        return $this->createQueryBuilder('r')
            ->addSelect('p')
            ->addSelect('u')
            ->addSelect('a')
            ->innerJoin('r.product', 'p')
            ->innerJoin('r.user', 'u')
            ->innerJoin('r.agency', 'a')
            ->orderBy('r.dateCreate', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
