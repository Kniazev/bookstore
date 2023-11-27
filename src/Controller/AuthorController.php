<?php

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
            !empty($authors = $this->authorService->getAll())
                ? $authors
                : null,
        ]);
    }

    /**
     * @Route("/authors/{id}", name="app_authors_get_by_id")
     */
    public function getAuthorById(int $id): JsonResponse
    {
        return $this->json([
            !empty($author = $this->authorService->getById($id))
                ? $author
                : null,
        ]);
    }

    /**
     * @Route("/authors/books/{id}", name="app_author_get_books")
     */
    public function getAuthorBooks(int $id): JsonResponse
    {
        return $this->json([
            !empty($books = $this->bookService->getBooksByAuthorId($id))
                ? $books
                : null,
        ]);
    }
}
