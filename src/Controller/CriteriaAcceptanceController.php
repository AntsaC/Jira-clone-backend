<?php

namespace App\Controller;

use App\Entity\CriteriaAcceptance;
use App\Repository\CriteriaAcceptanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class CriteriaAcceptanceController extends AbstractController
{

    public function __construct(
        private readonly CriteriaAcceptanceRepository $repository
    )
    {
    }

    #[Route('/user-stories/{userStoryId}/criteria', methods: ['GET'])]
    public function getAllByUserStory(int $userStoryId): JsonResponse
    {
        return $this->json(
            $this->repository->findAllByUserStory($userStoryId),
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['userStory']
            ]
        );
    }
    #[Route('/user-stories/{userStoryId}/criteria', methods: ['POST'])]
    public function createCriteria(int $userStoryId,#[MapRequestPayload] CriteriaAcceptance $criteriaAcceptance): JsonResponse
    {
        $this->repository->persistByUserStory($userStoryId, $criteriaAcceptance);
        return $this->json(
            $criteriaAcceptance,
            status: 201,
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['userStory']
            ]
        );
    }

    #[Route('/user-stories/{userStoryId}/criteria/{id}', methods: ['PUT'])]
    public function update(int $userStoryId, int $id, #[MapRequestPayload] CriteriaAcceptance $criteriaAcceptance): JsonResponse
    {
        return $this->json(
            $this->repository->update($id, $criteriaAcceptance),
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['userStory']
            ]
        ) ;
    }

}