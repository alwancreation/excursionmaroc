<?php

namespace App\Services;

use App\Entity\Category;
use App\Entity\Destination;
use App\Entity\ExcursionSchedule;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Request;

/**
 * Construit la requête Doctrine de recherche d'excursions à partir des
 * critères de la requête HTTP. Toujours limité aux excursions PUBLISHED
 * et construit via QueryBuilder (paramètres liés, pas de concaténation de
 * chaînes SQL) pour rester correct et facile à faire évoluer.
 */
class SearchService
{
    public const SORT_RECOMMENDED = 'recommended';
    public const SORT_PRICE_ASC = 'price_asc';
    public const SORT_PRICE_DESC = 'price_desc';
    public const SORT_NEWEST = 'newest';

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return array{query: Query, category: Category|null, destination: Destination|null, criteria: array}
     */
    public function search(Request $request, array $defaults = []): array
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('p')
            ->from(Product::class, 'p')
            ->andWhere('p.status = :status')
            ->setParameter('status', Product::STATUS_PUBLISHED);

        $categoryId = $request->query->get('category', $defaults['category'] ?? null);
        $category = $categoryId ? $this->em->getRepository(Category::class)->find($categoryId) : null;
        if ($category) {
            $qb->andWhere('p.category = :category')->setParameter('category', $category);
        }

        $destinationId = $request->query->get('destination', $defaults['destination'] ?? null);
        $destination = $destinationId ? $this->em->getRepository(Destination::class)->find($destinationId) : null;
        if ($destination) {
            $qb->andWhere(':destination MEMBER OF p.destinations')->setParameter('destination', $destination);
        }

        $q = trim((string) $request->query->get('q', ''));
        if ($q !== '') {
            $qb->andWhere('p.productName LIKE :q')->setParameter('q', '%' . $q . '%');
        }

        $priceMin = $request->query->get('price_min');
        if ($priceMin !== null && $priceMin !== '') {
            $qb->andWhere('p.productPrice >= :priceMin')->setParameter('priceMin', (float) $priceMin);
        }

        $priceMax = $request->query->get('price_max');
        if ($priceMax !== null && $priceMax !== '') {
            $qb->andWhere('p.productPrice <= :priceMax')->setParameter('priceMax', (float) $priceMax);
        }

        $participants = $request->query->get('participants');
        if ($participants !== null && $participants !== '') {
            $qb->andWhere('p.maxPersons IS NULL OR p.maxPersons >= :participants')
                ->setParameter('participants', (int) $participants);
        }

        $type = $request->query->get('type');
        if ($type === 'private') {
            $qb->andWhere('p.private = true');
        } elseif ($type === 'group') {
            $qb->andWhere('(p.private = false OR p.private IS NULL)');
        }

        if ($request->query->getBoolean('transport')) {
            $qb->andWhere('p.transportIncluded = true');
        }

        if ($request->query->getBoolean('guide')) {
            $qb->andWhere('p.guideIncluded = true');
        }

        $date = $request->query->get('date');
        if ($date) {
            try {
                $dateObj = new \DateTime($date);
                $sub = $this->em->createQueryBuilder()
                    ->select('1')
                    ->from(ExcursionSchedule::class, 's')
                    ->andWhere('s.product = p')
                    ->andWhere('s.date >= :searchDate')
                    ->andWhere('s.remainingCapacity > 0')
                    ->andWhere('s.status != :cancelled');
                $qb->andWhere($qb->expr()->exists($sub->getDQL()))
                    ->setParameter('searchDate', $dateObj)
                    ->setParameter('cancelled', ExcursionSchedule::STATUS_CANCELLED);
            } catch (\Exception $e) {
                // invalid date input, ignore the filter rather than error out
            }
        }

        // Note: KnpPaginator itself reserves the "sort"/"direction" query
        // params for its own column-sorting feature, so our own sort
        // criterion uses a different name to avoid the collision.
        $sort = $request->query->get('sort_by', self::SORT_RECOMMENDED);
        switch ($sort) {
            case self::SORT_PRICE_ASC:
                $qb->orderBy('p.productPrice', 'ASC');
                break;
            case self::SORT_PRICE_DESC:
                $qb->orderBy('p.productPrice', 'DESC');
                break;
            case self::SORT_NEWEST:
                $qb->orderBy('p.dateCreate', 'DESC');
                break;
            // "top_rated" and "popular" need Review/Booking data (later phases);
            // until then they fall back to the recommended order below.
            case self::SORT_RECOMMENDED:
            default:
                $qb->orderBy('p.productOrder', 'ASC')->addOrderBy('p.productId', 'DESC');
                break;
        }

        return [
            'query' => $qb->getQuery(),
            'category' => $category,
            'destination' => $destination,
            'criteria' => [
                'q' => $q,
                'price_min' => $priceMin,
                'price_max' => $priceMax,
                'participants' => $participants,
                'type' => $type,
                'transport' => $request->query->getBoolean('transport'),
                'guide' => $request->query->getBoolean('guide'),
                'date' => $date,
                'sort' => $sort,
            ],
        ];
    }
}
