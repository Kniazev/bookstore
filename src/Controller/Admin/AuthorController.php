<?php

namespace App\Admin\Controller;

use App\Service\AuthorServiceInterface;
use App\Service\BookServiceInterface;
use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


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
     * @Route("/admin/authors", name="app_admin_authors")
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
     * @Route("/admin/authors/{id}", name="app_admin_authors_get_by_id")
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
     * @Route("/admin/authors/books/{id}", name="app_admin_author_get_books")
     */
    public function getAuthorBooks(int $id): JsonResponse
    {
        return $this->json([
            !empty($books = $this->bookService->getBooksByAuthorId($id))
                ? $books
                : null,
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="app_admin_authors_delete")
     */
    public function delete(int $id): JsonResponse
    {
        if (empty($id)) {
            return $this->json([
                'Id is empty',
            ]);
        }

        try {
            $this->authorService->delete($id);

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
     * @Route("/admin/authors/create", name="app_admin_author_create")
     */
    public function createAuthors(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $context = json_decode($request->getContent(), true);

        $author = new Author();
        $author->setFirstName($context['first_name'])
            ->setLastName($context['last_name']);

        $errors = $validator->validate($author);

        if (count($errors) > 0) {
            return $this->json(
                [
                    $errors,
                    'Something went wrong',
                ],
                500
            );
        }

        $this->authorService->create($author);

        return $this->json([
            $author,
        ]);
    }

    /**
     * @Route("/admin/authors/add-book", name="app_admin_author_add_book")
     */
    public function addBooks(Request $request): JsonResponse
    {
        $context = json_decode($request->getContent(), true);

        if (empty($context['author_id']) || empty($context['books'] || !is_array($context['books']))) {
            return $this->json([
                'Needed field is empty',
            ], 400);
        }

        $this->authorService->addBooks($context['author_id'], $context['books']);

        return $this->json([
            'Books were successful added'
        ]);
    }
}
