<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\tests\AbstractCustomTest;
use App\Tests\MockEntities;


class BookServiceTest extends AbstractCustomTest
{

    private MockEntities $mockEntities;
    private Object $bookRepository;
    private BookServiceInterface $bookService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockEntities = new MockEntities();
        $this->bookRepository = $this->getRepositoryForEntity(Book::class);
        $this->bookService = new BookService($this->bookRepository);
    }

    /**
     * @return void
     */
    public function testGetById(): void
    {
        $insertedBook = $this->addBookToDB();

        $foundBook = $this->bookService->GetById($insertedBook->getId());
        $this->assertEquals($insertedBook->getTitle(), $foundBook->getTitle());
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $insertedBook = $this->addBookToDB();

        $this->assertTrue($this->bookService->delete($insertedBook->getId()));
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $expectedBook = $this->mockEntities->createBook();

        $insertedBook = $this->bookService->create($expectedBook);

        $this->assertEquals($expectedBook->getTitle(), $insertedBook->getTitle());
    }

    /**
     * @return void
     */
    public function testGetBooksByAuthorId(): void
    {
        $foundBooks =  $this->bookRepository->getBooksByAuthorId($this->author->getId());

        $this->assertNotEmpty($foundBooks);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $expectedBook = $this->addBookToDB();

        $expectedBook->setTitle('New title');
        $this->bookService->update();

        $updatedBook = $this->entityManager->find(Book::class, $expectedBook->getId());

        $this->assertEquals($expectedBook, $updatedBook);
    }

    /**
     * @return void
     */
    public function testGetAll(): void
    {
        $this->assertNotEmpty($this->bookService->getAll());
    }

    /**
     * @return Book
     */
    private function addBookToDB(): Book
    {
        $book = $this->mockEntities->createBook();

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $book;
    }
}
