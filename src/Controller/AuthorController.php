<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AuthorServiceInterface;
use App\Service\BookServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private AuthorServiceInterface $authorService;
    private BookServiceInterface $bookService;

    /**
     * @param AuthorServiceInterface $authorService
     * @param BookServiceInterface $bookService
     */
    public function __construct(AuthorServiceInterface $authorService, BookServiceInterface $bookService)
    {
        $this->authorService = $authorService;
        $this->bookService = $bookService;
    }

    /**
     * @Route("/authors", name="app_authors")
     */
    public function authorsList(): JsonResponse
    {
        return $this->json([
            $this->authorService->getAll(),
        ]);
    }

    /**
     * @Route("/authors/{id}", name="app_authors_get_by_id")
     */
    public function getAuthorById(int $id): JsonResponse
    {
        return $this->json([
            $this->authorService->getById($id),
        ]);
    }

    /**
     * @Route("/authors/books/{id}", name="app_author_get_books")
     */
    public function getAuthorBooks(int $id): JsonResponse
    {
        return $this->json([
            $this->bookService->getBooksByAuthorId($id),
        ]);
    }
}
