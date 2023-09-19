<?php

namespace App\Repository;

use App\Entity\ClasseurTux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClasseurTux>
 *
 * @method ClasseurTux|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClasseurTux|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClasseurTux[]    findAll()
 * @method ClasseurTux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasseurTuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClasseurTux::class);
    }

//    /**
//     * @return ClasseurTux[] Returns an array of ClasseurTux objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ClasseurTux
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
