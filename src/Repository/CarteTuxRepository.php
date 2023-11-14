<?php

namespace App\Repository;

use App\Entity\CarteTux;
use App\Entity\MembreTux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarteTux>
 *
 * @method CarteTux|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarteTux|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarteTux[]    findAll()
 * @method CarteTux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarteTuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarteTux::class);
    }
    /**
     * @return [Objet][] Returns an array of [Objet] objects for a member
     */
    public function findMemberCartesTux(MembreTux $member): array
    {
            return $this->createQueryBuilder('o')
                    ->leftJoin('o.classeurTux', 'i')
                    ->andWhere('i.membreTux = :member')
                    ->setParameter('member', $member)
                    ->getQuery()
                    ->getResult()
            ;
    }
 

//    /**
//     * @return CarteTux[] Returns an array of CarteTux objects
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

//    public function findOneBySomeField($value): ?CarteTux
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
