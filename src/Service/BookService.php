<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\Query;


class BookService implements BookServiceInterface
{
    /**
     * @var BookRepository
     */
    private BookRepository $bookRepository;

    /**
     * @param BookRepository $bookRepository
     */
    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param Book $book
     * @return void
     */
    public function create(Book $book): Book
    {
        $this->bookRepository->add($book);

        return $book;
    }

    /**
     * @param int $id
     * @return Book|null
     */
    public function getById(int $id): ?Book
    {
        return $this->bookRepository->find($id);
    }

    /**
     * @return array|null
     */
    public function getAll(): ?array
    {
        return $this->bookRepository->findAll();
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $this->bookRepository->commit();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $book = $this->bookRepository->find($id);

        if (empty($book)) {
            return false;
        }

        $this->bookRepository->removeAndCommit($book);

        return true;
    }

    /**
     * @param int $authorId
     * @return Query
     */
    public function getBooksByAuthorId(int $authorId): Query
    {
        return $this->bookRepository->getBooksByAuthorId($authorId);
    }

    /**
     * @param int $authorId
     * @param array $books
     * @return bool
     */
    public function addBooks(int $authorId, array $books): bool
    {
        if (empty($books) || empty($authorId)) {
            return false;
        }

        $author = $this->getById($authorId);

        foreach ($books as $book) {
            $this->validator->validate($book);

            $author->addBook($book);
        }

        $this->update();

        return true;
    }

    /**
     * @param int $bookId
     * @param array $authors
     * @return bool
     */
    public function addAuthors(int $bookId, array $authors): bool
    {
        if (empty($authors) || empty($bookId)) {
            return false;
        }

        $book = $this->getById($bookId);

        foreach ($authors as $author) {
            $this->validator->validate($author);

            $book->addBook($author);
        }

        $this->update();

        return true;
    }
}
