<?php

namespace App\Repository;

use App\Entity\CriteriaAcceptance;
use App\Entity\UserStory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CriteriaAcceptance>
 *
 * @method CriteriaAcceptance|null find($id, $lockMode = null, $lockVersion = null)
 * @method CriteriaAcceptance|null findOneBy(array $criteria, array $orderBy = null)
 * @method CriteriaAcceptance[]    findAll()
 * @method CriteriaAcceptance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CriteriaAcceptanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CriteriaAcceptance::class);
    }

    public function findAllByUserStory(int $userStoryId)
    {
        return $this->getEntityManager()
            ->createQuery(sprintf("select c from %s c where c.userStory = ?1", CriteriaAcceptance::class))
            ->setParameter(1, $userStoryId)
            ->getResult();
    }

    public function persistByUserStory(int $userStoryId, CriteriaAcceptance $criteriaAcceptance): void
    {
        $criteriaAcceptance->setUserStory($this->getEntityManager()->getReference(UserStory::class, $userStoryId));
        $this->getEntityManager()->persist($criteriaAcceptance);
        $this->getEntityManager()->flush();
    }

    public function update(int $id, CriteriaAcceptance $criteriaAcceptance): ?CriteriaAcceptance
    {
        $criteria = $this->find($id);
        $criteria->setCriteria($criteriaAcceptance->getCriteria());
        $criteria->setChecked($criteriaAcceptance->isChecked());
        $this->getEntityManager()->flush();
        return $criteria;
    }
}
