<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Author;


interface AuthorServiceInterface
{
    /**
     * @param Author $author
     * @return void
     */
    public function create(Author $author): void;

    /**
     * @param int $id
     * @return Author|null
     */
    public function getById(int $id): ?Author;

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
    public function getAuthorsByBooksId(int $bookId): ?array;

}
