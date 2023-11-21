<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Author;


interface AuthorServiceInterface
{
    /**
     * @param Author $author
     * @return Author
     */
    public function create(Author $author): Author;

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
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * @param int $bookId
     * @return array|null
     */
    public function getAuthorsByBooksId(int $bookId): ?array;

}
