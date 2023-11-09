<?php

namespace App\Repository;

use App\Entity\ActionReforme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActionReforme>
 *
 * @method ActionReforme|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActionReforme|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActionReforme[]    findAll()
 * @method ActionReforme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionReformeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActionReforme::class);
    }

//    /**
//     * @return ActionReforme[] Returns an array of ActionReforme objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ActionReforme
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
