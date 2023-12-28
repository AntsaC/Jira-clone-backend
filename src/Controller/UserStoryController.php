<?php

namespace App\Controller;

use App\Dto\Input\MoveActionInput;
use App\Dto\Input\PartialStory;
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

    #[Route("sprints/{sprintId}/stories", methods: ['GET'])]
    public function findAllBySprint(int $sprintId): JsonResponse
    {
        return $this->json($this->repository->findAllBySprint($sprintId));
    }

    #[Route('sprints/{sprintId}/point', methods: ['GET'])]
    public function computePointsGroupByStatusAndSprint(int $sprintId): JsonResponse
    {
        return $this->json($this->repository->computeStoryPointBySprint($sprintId));
    }

    #[Route('projects/{id}/point', methods: ['GET'])]
    public function computePointsGroupByStatusAndProject(int $id): JsonResponse
    {
        return $this->json($this->repository->computeStoryPointByProjectBacklog($id));
    }

    #[Route('projects/{projectId}/user-stories', methods: ['POST'])]
    public function addUserStory(int $projectId, #[MapRequestPayload] UserStory $userStory): JsonResponse
    {
        $this->repository->persist($projectId, $userStory);
        return $this->json(
            $userStory,
            status: 201,
            headers: [
                'location' => $this->generateUrl('one_user_story',['projectId' => $projectId, 'id' => $userStory->getId()])
            ],
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['project', 'cards']
            ]
        );
    }

    #[Route('projects/{projectId}/user-stories/{id}', name: 'one_user_story', methods: ['GET'])]
    public function getOneById(UserStory $userStory): JsonResponse
    {
        return $this->json(
            $userStory,
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['project', 'cards']
            ]
        );
    }

    #[Route('projects/{projectId}/user-stories/{id}', methods: ['PUT'])]
    public function update(int $id, #[MapRequestPayload] UserStory $userStory): JsonResponse
    {
        $updatedUserStory = $this->repository->update($id, $userStory);
        return $this->json(
            $updatedUserStory,
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['cards','project']
            ]
        );
    }

    #[Route('user-stories/{id}', methods: ['PATCH'])]
    public function partialUpdate(int $id, #[MapRequestPayload] PartialStory $partialStory): JsonResponse
    {
        $story = $this->repository->partialUpdate($id, $partialStory);
        return $this->json(
            $story,
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['cards', 'project']
            ]
        );
    }

    #[Route('user-stories/move', methods: ['PUT'])]
    public function moveStory(#[MapRequestPayload] MoveActionInput $moveActionInput): JsonResponse
    {
        $this->repository->moveStory($moveActionInput);
        return $this->json(
            null,
            status: 204
        );
    }

    #[Route('projects/{projectId}/user-stories/{id}', methods: ['DELETE'])]
    public function delete(UserStory $userStory): JsonResponse
    {
        $this->repository->delete($userStory);
        return $this->json(null, status: 204);
    }

}
