<?php

namespace App\Controller;

use App\Dto\Input\ProjectFilterDto;
use App\Entity\Project;
use App\Entity\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projects')]
class ProjectController extends AbstractController
{
    public function __construct(
        private readonly ProjectRepository $repository,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('', methods: ['GET'])]
    public function index(#[MapQueryString] ?ProjectFilterDto $filter): JsonResponse
    {
        return $this->json($this->repository->findAllProject($filter ?? new ProjectFilterDto()));
    }

    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload] Project $project): JsonResponse
    {
        $project->setType($this->entityManager->getReference(ProjectType::class, $project->getType()->getId()));
        $this->entityManager->persist($project);
        $this->entityManager->flush();
        return $this->json($project, status: 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, #[MapRequestPayload] Project $project): JsonResponse
    {
        $currentProject = $this->repository->find($id);
        $currentProject->setName($project->getName());
        $currentProject->setType($this->entityManager->getReference(ProjectType::class, $project->getType()->getId()));
        $this->entityManager->flush();
        return $this->json($currentProject);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function oneById(int $id): JsonResponse
    {
        return $this->json(
            $this->repository->find($id)
        );
    }

    #[Route('/{key}', methods: ['GET'])]
    public function oneByKey(string $key): JsonResponse
    {
        return $this->json(
            $this->repository->findOneBy(['key' => $key])
        );
    }

}