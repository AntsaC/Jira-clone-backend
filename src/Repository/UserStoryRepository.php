<?php

namespace App\Repository;

use App\Dto\output\StoryPointDetailDto;
use App\Entity\OrderedStories;
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

    public function findAllBySprint(int $sprintId)
    {
        return $this->getEntityManager()
            ->createQuery(sprintf('select us, s from %s u join %s us with us.id = u.id left join us.status s where %s', OrderedStories::class,UserStory::class, $this->parentCondition(isInBacklog: false)))
            ->setParameter(1, $sprintId)
            ->getResult();
    }

    public function reorder(int $replacedStoryId, UserStory $story, $isPushing = false): void
    {
        $nextStory = $this->getNextStory($story);
        $nextStory?->setPrevious($story->getPrevious());
        $replacedStory = $this->find($replacedStoryId);
        if(!$isPushing) {
            $story->setPrevious($replacedStory->getPrevious());
            $replacedStory->setPrevious($story);
        } else {
            $story->setPrevious($replacedStory);
        }
        $this->getEntityManager()->flush();
    }

    public function getNextStory(UserStory $story): ?UserStory {
        return $this->getEntityManager()
            ->createQuery(sprintf("select u from %s u where u.previous = ?1 ", UserStory::class))
            ->setParameter(1, $story)
            ->getOneOrNullResult();
    }

    /**
     * @throws ORMException
     */
    public function persist(int $projectId, UserStory $userStory): void
    {
        $entityManager = $this->getEntityManager();
        $userStory->setProject($entityManager->getReference(Project::class, $projectId));
        if ($userStory->getSprint()) {
            $userStory->setSprint($entityManager->getReference(Sprint::class, $userStory->getSprint()->getId()));
        }
        if($userStory->getPrevious()) {
            $userStory->setPrevious($entityManager->getReference(UserStory::class, $userStory->getPrevious()->getId()));
        }
        $entityManager->persist($userStory);
        $entityManager->flush();
    }

    public function update(int $id, UserStory $userStory): ?UserStory
    {
        $userStory1 = $this->find($id);
        $userStory1->setSummary($userStory->getSummary());
        if ($userStory->getSprint()) {
            $userStory1->setSprint($this->getEntityManager()->getReference(Sprint::class, $userStory->getSprint()->getId()));
        }
        $this->getEntityManager()->flush();
        return $userStory1;
    }

    public function delete(UserStory $userStory)
    {
        $this->getEntityManager()->remove($userStory);
    }

    public function findAllByBacklog(int $projectId)
    {
        return $this->getEntityManager()
            ->createQuery(sprintf('select us,s from %s u join %s us with us.id = u.id left join us.status s where %s', OrderedStories::class, UserStory::class, $this->parentCondition()))
            ->setParameter(1, $projectId)
            ->getResult();
    }

    public function computeStoryPointGroupByStatus(int $parent, $isInBacklog = true): StoryPointDetailDto
    {
        $groupByCondition = $isInBacklog ? 'project' : 'sprint';
        $points = $this->getEntityManager()
            ->createQuery(
                sprintf('select s.name, sum(u.storyPoint) points from %s u left join u.status s where %s group by u.%s, s', UserStory::class, $this->parentCondition(isInBacklog: $isInBacklog), $groupByCondition)
            )->setParameter(1, $parent)
            ->getResult();
        return StoryPointDetailDto::mapFromArray($points);
    }

    private function parentCondition($alias = 'u', $isInBacklog = true): string
    {
        return $isInBacklog ? "$alias.project = ?1 and $alias.sprint is null" : "$alias.sprint = ?1";
    }

}
