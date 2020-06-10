<?php

namespace App\Repository;

use App\Entity\DienstenKapper;
use App\Entity\Kapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Kapper|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kapper|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kapper[]    findAll()
 * @method Kapper[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KapperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kapper::class);
    }

    // /**
    //  * @return Kapper[] Returns an array of Kapper objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Kapper
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
