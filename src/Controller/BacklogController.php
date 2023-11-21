<?php

namespace App\Controller;

use App\Repository\UserStoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class BacklogController extends AbstractController
{
    public function __construct(
        private readonly UserStoryRepository $repository
    )
    {
    }

    #[Route('/projects/{projectId}/backlog', methods: ['GET'])]
    public function backlogByProject(int $projectId): JsonResponse
    {
        return $this->json(
            [
                "cards" => $this->repository->findAllByProjectAndNotInSprint($projectId)
            ],
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['project', 'sprint']
            ]
        );
    }


}