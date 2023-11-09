<?php

namespace App\Repository;

use App\Entity\Planifier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Planifier>
 *
 * @method Planifier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planifier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planifier[]    findAll()
 * @method Planifier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanifierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planifier::class);
    }

//    /**
//     * @return Planifier[] Returns an array of Planifier objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Planifier
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
