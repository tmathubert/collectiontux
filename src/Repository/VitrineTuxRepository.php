<?php

namespace App\Repository;

use App\Entity\VitrineTux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VitrineTux>
 *
 * @method VitrineTux|null find($id, $lockMode = null, $lockVersion = null)
 * @method VitrineTux|null findOneBy(array $criteria, array $orderBy = null)
 * @method VitrineTux[]    findAll()
 * @method VitrineTux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VitrineTuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VitrineTux::class);
    }
    
    public function findAll(): array
    {
        return $this->findBy(['ispublic'=>true]);
    }

//    /**
//     * @return VitrineTux[] Returns an array of VitrineTux objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VitrineTux
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
