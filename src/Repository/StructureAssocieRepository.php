<?php

namespace App\Repository;

use App\Entity\StructureAssocie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StructureAssocie>
 *
 * @method StructureAssocie|null find($id, $lockMode = null, $lockVersion = null)
 * @method StructureAssocie|null findOneBy(array $criteria, array $orderBy = null)
 * @method StructureAssocie[]    findAll()
 * @method StructureAssocie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StructureAssocieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StructureAssocie::class);
    }

//    /**
//     * @return StructureAssocie[] Returns an array of StructureAssocie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StructureAssocie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
