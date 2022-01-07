<?php

namespace App\Repository;

use App\Data\PropertyData;
use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\PropertySearch;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }
   

    /**
     *
     * @return Property[]
     */
    public function findAllVisible()
    {
        return $this->createQueryBuilder('p')
        ->getQuery()
        ->getResult();
    }

    /**
     *
     * @return Property[]
     */
    public function findLatest()
    {
        return $this->createQueryBuilder('property')
        ->orderBy('property.created_at', 'DESC')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();
    } 
    private function findVisibleQuery()
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }
    /**
     * @return Query
     */
    public function findAllVisibleQuery(PropertySearch $search)
    {
        $query = $this->findVisibleQuery();
        if ($search->getMinPrice()) {
            $query = $query
                ->andWhere('p.price >= :minprice')
                ->setParameter('minprice', $search->getMinPrice());
        }
        if ($search->getMaxPrice()) {
            $query = $query
                ->andWhere('p.price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }

        if ($search->getMinSurface()) {
            $query = $query
                ->andWhere('p.surface >= :minsurface')
                ->setParameter('minsurface', $search->getMinSurface());
        }
        if ($search->getMaxSurface()) {
            $query = $query
                ->andWhere('p.surface <= :maxsurface')
                ->setParameter('maxsurface', $search->getMaxSurface());
        }
        return $query->getQuery();
    }

    private function getSearchQuery(PropertyData $search, $ignorePrice = false)
    {
        $query = $this
            ->createQueryBuilder('property')
            ->orderBy('property.created_at', 'DESC');

            if(!empty($search->job)) {
                $query = $query 
                        ->andWhere('property.title LIKE :job')
                        ->setParameter('job', "%{$search->job}%");
            } 
            
            if(!empty($search->city)) {
                $query = $query 
                        ->andWhere('property.city LIKE :city')
                        ->setParameter('city', "%{$search->city}%");
            }

            if(!empty($search->min) && $ignorePrice = false){
                $query = $query 
                ->andWhere('property.price >= :min')
                ->setParameter('min', $search->min);
            }
            

            if(!empty($search->max)){
                $query = $query 
                ->andWhere('property.price <= :max')
                ->setParameter('max', $search->max);
            }
            return $query;
    }
  /**
     * Récupère le prix min et max de la recherche
     * @param PropertyData $search
     * @return integer[]
     */
    public function findMinMax(PropertyData $search): array
    {
        $results = $this->getSearchQuery($search, true)
            ->select('MIN(property.price) as min', 'MAX(property.price) as max')
            ->getQuery()
            ->getScalarResult();
            return [(int)$results[0]['min'], (int)$results[0]['max']];
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
