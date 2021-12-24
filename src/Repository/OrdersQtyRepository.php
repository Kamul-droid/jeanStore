<?php

namespace App\Repository;

use App\Entity\OrdersQty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrdersQty|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdersQty|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdersQty[]    findAll()
 * @method OrdersQty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersQtyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdersQty::class);
    }

    // /**
    //  * @return OrdersQty[] Returns an array of OrdersQty objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrdersQty
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
