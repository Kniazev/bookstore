<?php

namespace App\Service;

use App\Entity\Book;

interface BookServiceInterface
{
    /**
     * @param Book $book
     * @return Book
     */
    public function create(Book $book): Book;

    /**
     * @param int $id
     * @return Book|null
     */
    public function getById(int $id): ?Book;

    /**
     * @return array|null
     */
    public function getAll(): ?array;

    /**
     * @return void
     */
    public function update(): void;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * @param int $bookId
     * @return array|null
     */
    public function getBooksByAuthorId(int $bookId): ?array;
}