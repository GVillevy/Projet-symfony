<?php

namespace App\Repository;

use App\Entity\WorldRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorldRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorldRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorldRecord[]    findAll()
 * @method WorldRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorldRecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorldRecord::class);
    }

    // /**
    //  * @return WorldRecord[] Returns an array of WorldRecord objects
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
    public function findOneBySomeField($value): ?WorldRecord
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
