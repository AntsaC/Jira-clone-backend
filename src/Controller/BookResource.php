<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/books')]
class BookResource extends AbstractController
{
    public function __construct(
        private readonly BookRepository $repository
    )
    {
    }

    #[Route('/', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json($this->repository->findAllBook());
    }

}