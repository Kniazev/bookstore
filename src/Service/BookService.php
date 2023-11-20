<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;


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
    public function create(Book $book): void
    {
        $this->bookRepository->add($book);
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
     * @return void
     */
    public function delete(int $id): void
    {
        $book = $this->bookRepository->find($id);
        $this->bookRepository->removeAndCommit($book);
    }

    /**
     * @param int $authorId
     * @return array|null
     */
    public function getBooksByAuthorId(int $authorId): ?array
    {
        return $this->bookRepository->getBooksByAuthorId($authorId);
    }
}
