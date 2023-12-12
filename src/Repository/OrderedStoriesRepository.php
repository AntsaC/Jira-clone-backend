<?php

namespace App\Repository;

use App\Entity\OrderedStories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderedStories>
 *
 * @method OrderedStories|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderedStories|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderedStories[]    findAll()
 * @method OrderedStories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderedStoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderedStories::class);
    }

//    /**
//     * @return OrderedStories[] Returns an array of OrderedStories objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrderedStories
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
