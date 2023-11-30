<?php

namespace App\Admin\Controller;

use App\Entity\Book;
use App\Service\AuthorServiceInterface;
use App\Service\BookServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


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
     * @Route("/admin/books", name="app_admin_books")
     */
    public function booksList(): JsonResponse
    {
        return $this->json([
            $this->bookService->getAll(),
        ]);
    }

    /**
     * @Route("/admin/books/{id}", name="app_admin_books_get_by_id")
     */
    public function getBookById(int $id): JsonResponse
    {
        return $this->json([
            $this->authorService->getById($id)
        ]);
    }

    /**
     * @Route("/admin/books/authors/{id}", name="app_admin_book_get_authors")
     */
    public function getAuthors(int $id): JsonResponse
    {
        return $this->json([
            $this->authorService->getAuthorsByBooksId($id),
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="app_admin_book_delete")
     */
    public function delete(int $id): JsonResponse
    {
        if (empty($id)) {
            return $this->json([
                'Id is empty',
            ]);
        }

        try {
            $this->bookService->delete($id);

            return $this->json([
                'Books were successful delete'
            ]);
        } catch (Exception $e) {
            return $this->json([
                'Something went wrong',
            ]);
        }
    }

    /**
     * @Route("/admin/books/create", name="app_admin_book_create")
     */
    public function createBook(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $context = json_decode($request->getContent(), true);

        $book = new Book();
        $book->setFirstName($context['first_name'])
            ->setLastName($context['last_name']);

        $errors = $validator->validate($book);

        if (count($errors) > 0) {
            return $this->json(
                [
                    $errors,
                    'Something went wrong',
                ],
                500
            );
        }

        $this->bookService->create($book);

        return $this->json([
            $book,
        ]);
    }

    /**
     * @Route("/admin/books/add-authors", name="app_admin_book_add_authors")
     */
    public function addBooks(Request $request): JsonResponse
    {
        $context = json_decode($request->getContent(), true);

        if (empty($context['book_id']) || empty($context['authors'] || !is_array($context['authors']))) {
            return $this->json([
                'Needed field is empty',
            ], 400);
        }

        $this->authorService->addBooks($context['book_id'], $context['authors']);

        return $this->json([
            'Books were successful added'
        ]);
    }
}
