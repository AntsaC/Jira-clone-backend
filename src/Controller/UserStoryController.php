<?php

namespace App\Controller;

use App\Entity\UserStory;
use App\Repository\UserStoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class UserStoryController extends AbstractController
{

    public function __construct(
        private readonly UserStoryRepository $repository
    )
    {
    }

    #[Route('projects/{projectId}/backlog/user-stories', methods: ['POST'])]
    public function addUserStoryByBacklog(int $projectId,#[MapRequestPayload] UserStory $userStory): JsonResponse
    {
        $this->repository->persistByBacklog($projectId, $userStory);
        return $this->json(
            $userStory,
            status: 201,
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['project']
            ]
        );
    }

}