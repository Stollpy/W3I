<?php

namespace App\Repository;

use App\Entity\FanAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FanAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method FanAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method FanAccount[]    findAll()
 * @method FanAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FanAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FanAccount::class);
    }

    // /**
    //  * @return FanAccount[] Returns an array of FanAccount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FanAccount
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
