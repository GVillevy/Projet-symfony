<?php

namespace App\Repository;

use App\Entity\WorldRecords;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorldRecords|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorldRecords|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorldRecords[]    findAll()
 * @method WorldRecords[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorldRecordsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorldRecords::class);
    }

    // /**
    //  * @return WorldRecords[] Returns an array of WorldRecords objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorldRecords
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
