<?php

namespace App\Repository;

use App\Entity\Reforme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reforme>
 *
 * @method Reforme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reforme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reforme[]    findAll()
 * @method Reforme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReformeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reforme::class);
    }

//    /**
//     * @return Reforme[] Returns an array of Reforme objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reforme
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
