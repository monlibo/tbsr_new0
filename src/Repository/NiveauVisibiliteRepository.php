<?php

namespace App\Repository;

use App\Entity\NiveauVisibilite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NiveauVisibilite>
 *
 * @method NiveauVisibilite|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiveauVisibilite|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiveauVisibilite[]    findAll()
 * @method NiveauVisibilite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiveauVisibiliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiveauVisibilite::class);
    }

//    /**
//     * @return NiveauVisibilite[] Returns an array of NiveauVisibilite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NiveauVisibilite
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

        public function verifierDoublon($code, $deletedBy){
            return $this->createQueryBuilder();
        }

        public function listeNiveauVisibilite(){
            return $this->createQueryBuilder('u')
                //->select('n')
                //->from('App\Entity\NiveauVisibilite', 'n')
                ->where('n.deleted_at = null')
                ->getFirstResult();
        }
}
