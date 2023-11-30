<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\Query;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class AuthorService implements AuthorServiceInterface
{
    /**
     * @var AuthorRepository
     */
    private AuthorRepository $authorRepository;

    private ValidatorInterface $validator;

    /**
     * @param AuthorRepository $authorRepository
     */
    public function __construct(AuthorRepository $authorRepository, ValidatorInterface $validator)
    {
        $this->authorRepository = $authorRepository;
        $this->validator = $validator;
    }

    /**
     * @param Author $author
     * @return Author
     */
    public function create(Author $author): Author
    {
        $this->authorRepository->add($author);

        return $author;
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
     * @return bool
     */
    public function delete(int $id): bool
    {
        $author = $this->authorRepository->find($id);

        if (empty($author)) {
            return false;
        }

        $this->authorRepository->removeAndCommit($author);

        return true;
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
     * @return Query
     */
    public function getAuthorsByBooksId(int $bookId): Query
    {
        return $this->authorRepository->getAuthorsByBooksId($bookId);
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
}
