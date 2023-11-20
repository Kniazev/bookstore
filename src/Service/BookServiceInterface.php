<?php

namespace App\Service;

use App\Entity\Book;

interface BookServiceInterface
{
    /**
     * @param Book $book
     * @return void
     */
    public function create(Book $book): void;

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
     * @return void
     */
    public function delete(int $id): void;

    /**
     * @param int $bookId
     * @return array|null
     */
    public function getBooksByAuthorId(int $bookId): ?array;
}