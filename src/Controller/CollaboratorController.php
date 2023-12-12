<?php

namespace App\Controller;

use App\Repository\CollaborationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class CollaboratorController extends AbstractController
{
    public function __construct(
        private readonly CollaborationRepository $repository
    )
    {
    }

    #[Route('/projects/{projectId}/collaborators', methods: ['GET'])]
    public function findAllByProject(int $projectId): JsonResponse
    {
        return $this->json($this->repository->findAllCollaboratorByProject($projectId));
    }

}