<?php

namespace App\Repository;

use App\Entity\Sprint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sprint>
 *
 * @method Sprint|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sprint|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sprint[]    findAll()
 * @method Sprint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SprintRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sprint::class);
    }

    public function findCurrentSprintByProject(int $projectId) {
        return $this->createQueryBuilder('s')
            ->select('s, cards')
            ->leftJoin('s.cards','cards')
            ->where('s.project = :projectId')
            ->andWhere(':currentDate between s.startDate and s.endDate')
            ->setParameter('projectId', $projectId)
            ->setParameter('currentDate', new \DateTime(), 'date')
            ->getQuery()
            ->getOneOrNullResult();
    }
}
