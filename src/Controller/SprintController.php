<?php

namespace App\Controller;

use App\Dto\Input\SprintFilter;
use App\Entity\Sprint;
use App\Repository\SprintRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class SprintController extends AbstractController
{
    public function __construct(
        private readonly SprintRepository $repository
    )
    {
    }

    #[Route('/projects/{projectId}/current-sprint', methods: ['GET'])]
    public function getCurrentSprint(int $projectId): JsonResponse
    {
        return $this->json(
            $this->repository->findCurrentSprintByProject($projectId),
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['project']
            ]
        );
    }

    #[Route('/projects/{projectId}/sprints', methods: ['GET'])]
    public function findAllByProject(int $projectId, #[MapQueryString] ?SprintFilter $filter): JsonResponse
    {
        return $this->json(
            $this->repository->findAllByProject($projectId, $filter ?? new SprintFilter()),
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['project']
            ]
        );
    }

    #[Route('/projects/{projectId}/sprints', methods: ['POST'])]
    public function createSprint(int $projectId, #[MapRequestPayload] Sprint $sprint): JsonResponse
    {
        return $this->json(
            $this->repository->create($projectId, $sprint),
            status: 201,
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['project']
            ]
        );
    }

    #[Route('/projects/{projectId}/sprints/{id}', methods: ['PUT'])]
    public function updateSprint(int $projectId, int $id, #[MapRequestPayload] Sprint $sprint): JsonResponse
    {
        return $this->json(
            $this->repository->update($id, $sprint),
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['project']
            ]
        );
    }

    #[Route('/projects/{project}/sprints/{id}', methods: ['GET'])]
    public function one(int $project, int $id): JsonResponse
    {
        return $this->json(
            $this->repository->findById($id, $project),
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['project']
            ]
        );
    }

}