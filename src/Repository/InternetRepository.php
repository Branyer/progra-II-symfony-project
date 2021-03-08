<?php

namespace App\Repository;

use App\Entity\Internet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Internet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Internet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Internet[]    findAll()
 * @method Internet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InternetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Internet::class);
    }

    // /**
    //  * @return Internet[] Returns an array of Internet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Internet
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
