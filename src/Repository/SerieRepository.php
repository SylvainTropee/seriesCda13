<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function findBestSeries()
    {

        //en DQL
        //écriture de la requête
//        $dql = "SELECT s
//        FROM App\Entity\Serie s
//        WHERE s.vote > 8 AND s.popularity > 100
//        ORDER BY s.popularity DESC";

        //avec le QueryBuilder
        $qb = $this->createQueryBuilder('s');
        $qb
            ->andWhere('s.vote > 8')
            ->andWhere('s.popularity > 100')
            ->addOrderBy('s.popularity', 'DESC');

        $query = $qb->getQuery();

        //ajout d'options et execution
        $query->setMaxResults(20);
        return $query->getResult();
    }

    public function findBestSeriesWithPagination(int $page){

        $qb = $this->createQueryBuilder('s');
        $qb->addOrderBy('s.popularity', 'DESC');

        $query = $qb->getQuery();
        $limit =  Serie::SERIE_PER_PAGE;
        $offset = ($page - 1) * $limit;

        $query->setMaxResults($limit);
        $query->setFirstResult($offset);

        return $query->getResult();
    }

}










