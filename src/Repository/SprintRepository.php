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
    public function __construct(
        ManagerRegistry $registry,
        private readonly ProjectRepository $projectRepository
    )
    {
        parent::__construct($registry, Sprint::class);
    }

    public function findCurrentSprintByProject(int $projectId) {
        $currentSprint = $this->createQueryBuilder('s')
            ->select('s, cards')
            ->leftJoin('s.cards','cards')
            ->where('s.project = :projectId')
            ->andWhere(':currentDate between s.startDate and s.endDate')
            ->setParameter('projectId', $projectId)
            ->setParameter('currentDate', new \DateTime(), 'date')
            ->getQuery()
            ->getOneOrNullResult();
        if(!$currentSprint) {
            $currentSprint = $this->createNextSprintByProject($projectId);
        }
        return $currentSprint;
    }

    private function createNextSprintByProject(int $projectId): Sprint
    {
        $project = $this->projectRepository->find($projectId);
        $project->incrementSprintIndex();
        $sprint = new Sprint();
        $sprint->setProject($project);
        $sprint->initName();
        $this->getEntityManager()
            ->persist($sprint);
        $this->getEntityManager()->flush();
        return $sprint;
    }
}
