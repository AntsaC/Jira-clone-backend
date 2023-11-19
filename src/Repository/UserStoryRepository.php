<?php

namespace App\Repository;

use App\Entity\UserStory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function findAllByProject(int $projectId)
    {
        return $this->createQueryBuilder('u')
        ->select('u')
        ->where('u.project = ?1 and u.sprint is null')
        ->setParameter(1, $projectId)
        ->getQuery()
        ->getResult();
    }
}