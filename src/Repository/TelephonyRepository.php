<?php

namespace App\Repository;

use App\Entity\Telephony;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Telephony|null find($id, $lockMode = null, $lockVersion = null)
 * @method Telephony|null findOneBy(array $criteria, array $orderBy = null)
 * @method Telephony[]    findAll()
 * @method Telephony[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelephonyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Telephony::class);
    }

    // /**
    //  * @return Telephony[] Returns an array of Telephony objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Telephony
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
