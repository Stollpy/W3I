<?php

namespace App\Repository;

use App\Entity\MainAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MainAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainAccount[]    findAll()
 * @method MainAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainAccount::class);
    }

    // /**
    //  * @return MainAccount[] Returns an array of MainAccount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MainAccount
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
