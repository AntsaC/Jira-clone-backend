<?php

namespace App\Repository;

use App\Entity\SprintStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SprintStatus>
 *
 * @method SprintStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method SprintStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method SprintStatus[]    findAll()
 * @method SprintStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SprintStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SprintStatus::class);
    }

//    /**
//     * @return SprintStatus[] Returns an array of SprintStatus objects
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

//    public function findOneBySomeField($value): ?SprintStatus
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
