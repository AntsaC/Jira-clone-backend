<?php

namespace App\Controller;

use App\Entity\UserStory;
use App\Repository\UserStoryRepository;
use http\Client\Curl\User;
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

    #[Route('projects/{projectId}/user-stories', methods: ['POST'])]
    public function addUserStory(int $projectId, #[MapRequestPayload] UserStory $userStory): JsonResponse
    {
        $this->repository->persist($projectId, $userStory);
        return $this->json(
            null,
            status: 201,
            headers: [
                'location' => $this->generateUrl('one_user_story',['projectId' => $projectId, 'id' => $userStory->getId()])
            ]
        );
    }

    #[Route('projects/{projectId}/user-stories/{id}', name: 'one_user_story', methods: ['GET'])]
    public function getOneById(int $id): JsonResponse
    {
        return $this->json(
            $this->repository->find($id),
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['project', 'cards']
            ]
        );
    }

    #[Route('projects/{projectId}/user-stories/{id}', methods: ['PUT'])]
    public function update(int $id, #[MapRequestPayload] UserStory $userStory) {
        $updatedUserStory = $this->repository->update($id, $userStory);
        return $this->json(
            $updatedUserStory,
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['sprint','project']
            ]
        );
    }



}