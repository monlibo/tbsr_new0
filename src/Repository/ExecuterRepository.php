<?php

namespace App\Repository;

use App\Entity\Executer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Executer>
 *
 * @method Executer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Executer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Executer[]    findAll()
 * @method Executer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExecuterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Executer::class);
    }

//    /**
//     * @return Executer[] Returns an array of Executer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Executer
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
