<?php

namespace App\Repository;

use App\Entity\Collaboration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Collaboration>
 *
 * @method Collaboration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaboration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaboration[]    findAll()
 * @method Collaboration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaborationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collaboration::class);
    }

    public function findAllCollaboratorByProject(int $projectId)
    {
        $collaborations = $this->getEntityManager()
            ->createQuery(sprintf('select c, collaborator from %s c join c.collaborator collaborator where c.project = ?1', Collaboration::class))
            ->setParameter(1, $projectId)
            ->getResult();
        return $this->extractCollaborator($collaborations);
    }

    private function extractCollaborator($collaborations) {
        return array_map(function (Collaboration $collaboration) {
            return $collaboration->getCollaborator();
        }, $collaborations);
    }
}
