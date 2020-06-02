<?php

namespace App\Repository;

use App\Entity\DienstenKapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DienstenKapper|null find($id, $lockMode = null, $lockVersion = null)
 * @method DienstenKapper|null findOneBy(array $criteria, array $orderBy = null)
 * @method DienstenKapper[]    findAll()
 * @method DienstenKapper[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DienstenKapperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DienstenKapper::class);
    }

    // /**
    //  * @return DienstenKapper[] Returns an array of DienstenKapper objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DienstenKapper
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
