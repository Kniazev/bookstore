<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use phpDocumentor\Reflection\Types\Collection;


class AuthorService implements AuthorServiceInterface
{
    /**
     * @var AuthorRepository
     */
    private AuthorRepository $authorRepository;

    /**
     * @param AuthorRepository $authorRepository
     */
    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @param Author $author
     * @return void
     */
    public function create(Author $author): void
    {
        $this->authorRepository->add($author);
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $this->authorRepository->commit();
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $author = $this->authorRepository->find($id);
        $this->authorRepository->removeAndCommit($author);
    }

    /**
     * @param int $id
     * @return Author|null
     */
    public function getById(int $id): ?Author
    {
        return $this->authorRepository->find($id);
    }

    /**
     * @return array|null
     */
    public function getAll(): ?array
    {
        return $this->authorRepository->findAll();
    }

    /**
     * @param int $bookId
     * @return array|null
     */
    public function getAuthorsByBooksId(int $bookId): ?array
    {
        return $this->authorRepository->getAuthorsByBooksId($bookId);
    }
}
