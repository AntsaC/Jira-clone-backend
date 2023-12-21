<?php

namespace App\Repository;

use App\Dto\Input\SprintFilter;
use App\Entity\Project;
use App\Entity\Sprint;
use App\Entity\SprintStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use function PHPUnit\Framework\returnCallback;

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
                's sprint',
                'case when s.endDate < :date then \'complete\' when :date < s.startDate then \'future\' when :date between s.startDate and s.endDate then \'current\' else \'unknown\' end as status'
            )
            ->where('s.project = ?1')
            ->setParameter(1, $projectId)
            ->setParameter('date', date('Y-m-d'));
    }

    public function findAllByProject(int $projectId, SprintFilter $filter) {
        $qb = $this->createFindAllSprintByProjectQuery($projectId);
        $this->buildDynamicPredicate($qb, $filter);
        return $qb->getQuery()->getResult();
    }

    public function findCurrentSprintByProject(int $projectId) {
        return $this->getEntityManager()
            ->createQuery(sprintf('select s from %s where current_date() between s.startDate and s.endDate and s.project = ?1', Sprint::class))
            ->setParameter(1, $projectId)
            ->getOneOrNullResult();
    }

    private function buildDynamicPredicate(QueryBuilder $qb, SprintFilter $filter): void
    {
        if($filter->status == 'ongoing') {
            $qb->andWhere('s.endDate >= :date or s.endDate is null');
        }
        if($filter->status == 'complete') {
            $qb->andWhere('s.endDate < :date');
        }
        if($filter->status == 'current') {
            $qb->andWhere(':date between s.startDate and s.endDate');
        }
        if($filter->status == 'future') {
            $qb->andWhere(':date < s.startDate');
        }
    }

    public function create(int $projectId, Sprint $sprint): Sprint {
        $sprint->setProject($this->getEntityManager()->getReference(Project::class, $projectId));
        $this->getEntityManager()->persist($sprint);
        $this->getEntityManager()->flush();
        return $sprint;
    }

    public function update(int $id, Sprint $sprint): Sprint
    {
        $currentSprint = $this->find($id);
        $currentSprint->setName($sprint->getName());
        $currentSprint->setStartDate($sprint->getStartDate());
        $currentSprint->setEndDate($sprint->getEndDate());
        $currentSprint->setGoal($sprint->getGoal());
        $this->getEntityManager()->flush();
        return $currentSprint;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findById(int $id, int $project)
    {
        $qb = $this->createFindAllSprintByProjectQuery($project);
        return $qb->andWhere('s.id = :id ')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }


}
