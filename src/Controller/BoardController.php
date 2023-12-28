<?php

namespace App\Controller;

use App\Service\BoardService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class BoardController extends AbstractController
{
    public function __construct(
        private readonly BoardService $service
    )
    {
    }

    #[Route('sprints/{id}/board', methods: ['GET'])]
    public function boardBySprint(int $id): JsonResponse
    {
        return $this->json(
            $this->service->createBoardBySprint($id),
            context: [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['sprint', 'project','status']
            ]
        );
    }
}