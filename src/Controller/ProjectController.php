<?php

namespace App\Controller;

use App\Dto\Input\ProjectFilterDto;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projects')]
class ProjectController extends AbstractController
{
    public function __construct(
        private readonly ProjectRepository $repository
    )
    {
    }

    #[Route('', methods: ['GET'])]
    public function index(#[MapQueryString] ?ProjectFilterDto $filter): JsonResponse
    {
        return $this->json($this->repository->findAllProject($filter));
    }

}