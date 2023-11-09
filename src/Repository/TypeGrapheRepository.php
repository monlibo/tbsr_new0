<?php

namespace App\Repository;

use App\Entity\TypeGraphe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeGraphe>
 *
 * @method TypeGraphe|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeGraphe|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeGraphe[]    findAll()
 * @method TypeGraphe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeGrapheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeGraphe::class);
    }

//    /**
//     * @return TypeGraphe[] Returns an array of TypeGraphe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeGraphe
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
