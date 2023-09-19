<?php

namespace App\Repository;

use App\Entity\MembreTux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MembreTux>
 *
 * @method MembreTux|null find($id, $lockMode = null, $lockVersion = null)
 * @method MembreTux|null findOneBy(array $criteria, array $orderBy = null)
 * @method MembreTux[]    findAll()
 * @method MembreTux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MembreTuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MembreTux::class);
    }

//    /**
//     * @return MembreTux[] Returns an array of MembreTux objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MembreTux
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
