<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\Sprint;
use App\Entity\SprintStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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
    public function __construct(
        ManagerRegistry $registry,
    )
    {
        parent::__construct($registry, Sprint::class);
    }

    private function createFindAllSprintByProjectQuery(int $projectId): QueryBuilder
    {
        return $this->createQueryBuilder('s')
            ->select(
                's',
                'case when s.endDate < current_date() then \'complete\' when current_date() < s.startDate then \'future\' else \'current\' end status'
            )
            ->where('s.project = ?1')
            ->setParameter(1, $projectId);
    }

    public function findAllByProject(int $projectId) {
        return $this->createFindAllSprintByProjectQuery($projectId)
            ->getQuery()
            ->getResult();
    }

    public function create(int $projectId, Sprint $sprint): Sprint {
        $sprint->setProject($this->getEntityManager()->getReference(Project::class, $projectId));
        $this->getEntityManager()->persist($sprint);
        $this->getEntityManager()->flush();
        return $sprint;
    }

}
