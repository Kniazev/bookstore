<?php

declare(strict_types=1);

namespace App\tests;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractCustomTest extends KernelTestCase
{
    protected const BOOK_TEST_TITLE = 'Test book';
    protected CONST BOOK_INSERTED_TEST_TITLE = 'Test inserted book';

    protected EntityManagerInterface $em;
    protected Book $book;
    protected Book $book1;
    protected Author $author;
    protected Author $author1;

    protected function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->book = (new Book())->setTitle('Test book');
        $this->book1 = (new Book())->setTitle('Test book1');

        $this->author = (new Author())->setLastName('Test')->setFirstName('Author');
        $this->author1 = (new Author())->setLastName('Test1')->setFirstName('Author1');
        $this->entityManager->persist($this->book);
        $this->entityManager->persist($this->book1);
        $this->author->addBook($this->book);
        $this->author->addBook($this->book1);
        $this->author1->addBook($this->book1);
        $this->entityManager->persist($this->author);
        $this->entityManager->persist($this->author1);

        $this->entityManager->flush();
    }

    protected function getRepositoryForEntity(string $entityClass): Object
    {
        return $this->entityManager->getRepository($entityClass);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
