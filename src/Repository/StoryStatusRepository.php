<?php

namespace App\Repository;

use App\Entity\StoryStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StoryStatus>
 *
 * @method StoryStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoryStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoryStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoryStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoryStatus::class);
    }

//    /**
//     * @return StoryStatus[] Returns an array of StoryStatus objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StoryStatus
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
