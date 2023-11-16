<?php

namespace App\Repository;

use App\Dto\Input\ProjectFilterDto;
use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function findAllProject(?ProjectFilterDto $filterDto) {
        $maxResults = 5 ;
        return $this->createQueryBuilder('p')
            ->select('p, t')
            ->join('p.type', 't')
            ->getQuery()
            ->setFirstResult($this->computeCurrentPage($filterDto?->page, $maxResults))
            ->setMaxResults($maxResults)
            ->getResult();
    }

    public function computeCurrentPage(?int $page, int $maxResult): int
    {
        return (($page ?? 1) - 1) * $maxResult;
    }

//    public function findOneBySomeField($value): ?Project
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
