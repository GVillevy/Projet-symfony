<?php

namespace App\Repository;

use App\Entity\PlayOfTheWeek;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlayOfTheWeek|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayOfTheWeek|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayOfTheWeek[]    findAll()
 * @method PlayOfTheWeek[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayOfTheWeekRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayOfTheWeek::class);
    }

    // /**
    //  * @return PlayOfTheWeek[] Returns an array of PlayOfTheWeek objects
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
    public function findOneBySomeField($value): ?PlayOfTheWeek
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
