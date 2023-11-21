<?php

namespace App\Controller;

use App\Repository\SprintRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['project','sprint']
            ]
        );
    }

}