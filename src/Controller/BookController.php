<?php

namespace App\Controller;

use App\Service\AuthorServiceInterface;
use App\Service\BookServiceInterface;
use App\DTO\BookDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
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
     * @Route("/books", name="app_books")
     */
    public function index(): JsonResponse
    {
        return $this->json([
            !empty($books = $this->bookService->getAll())
                ? $books
                : 'There are not any book collections.'
        ]);
    }

    /**
     * @Route("/books/{id}", name="app_books_book")
     */
    public function getBookById($id): JsonResponse
    {
        $book = $this->bookService->getById($id);

        if (empty($book)) {
            return $this->json([
                'Book is not exist',
            ]);
        }

        return $this->json([
            'book' => $book,
            'authors' => $this->authorService->getAuthorsByBooksId($book->getId())->execute(),
        ]);
    }
}
