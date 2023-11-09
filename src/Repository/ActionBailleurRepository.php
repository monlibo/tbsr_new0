<?php

namespace App\Repository;

use App\Entity\ActionBailleur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActionBailleur>
 *
 * @method ActionBailleur|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActionBailleur|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActionBailleur[]    findAll()
 * @method ActionBailleur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionBailleurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActionBailleur::class);
    }

//    /**
//     * @return ActionBailleur[] Returns an array of ActionBailleur objects
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

//    public function findOneBySomeField($value): ?ActionBailleur
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
