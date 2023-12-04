<?php

namespace App\Service;

use App\Entity\Book;
use Doctrine\ORM\Query;

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
     * @return Query
     */
    public function getBooksByAuthorId(int $bookId): Query;

    /**
     * @param string $title
     * @return Book
     */
    public function getBookByTitle(string $title): Book;

    /**
     * @param string $name
     * @return Query
     */
    public function getBooksByAuthorName(string $name): Query;
}