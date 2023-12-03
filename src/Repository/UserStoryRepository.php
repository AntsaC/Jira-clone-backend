<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\Sprint;
use App\Entity\UserStory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserStory>
 *
 * @method UserStory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserStory|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserStory[]    findAll()
 * @method UserStory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserStoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserStory::class);
    }

    public function findAllByProjectAndNotInSprint(int $projectId)
    {
        return $this->createQueryBuilder('u')
        ->select('u')
        ->where('u.project = ?1 and u.sprint is null')
            ->orderBy('u.id')
        ->setParameter(1, $projectId)
        ->getQuery()
        ->getResult();
    }

    /**
     * @throws ORMException
     */
    public function persist(int $projectId, UserStory $userStory): void
    {
        $entityManager = $this->getEntityManager();
        $userStory->setProject($entityManager->getReference(Project::class,$projectId));
        if($userStory->getSprint()) {
            $userStory->setSprint($entityManager->getReference(Sprint::class,$userStory->getSprint()->getId()));
        }
        $entityManager->persist($userStory);
        $entityManager->flush();
    }

    public function update(int $id, UserStory $userStory): ?UserStory
    {
        $userStory1 = $this->find($id);
        $userStory1->setSummary($userStory->getSummary());
        $userStory1->setSprint($userStory->getSprint());
        $this->getEntityManager()->flush();
        return $userStory1;
    }

    public function delete(UserStory $userStory)
    {
        $this->getEntityManager()->remove($userStory);
    }

}
