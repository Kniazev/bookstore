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

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockEntities = new MockEntities();
        $this->bookRepository = $this->getRepositoryForEntity(Book::class);
    }

    public function testGetById()
    {
        $foundBook = $this->bookRepository->findOneBy(['title'=> self::BOOK_TEST_TITLE]);
        $this->assertNotEmpty($foundBook);
    }

    public function testDelete()
    {
        $book = $this->mockEntities->createBook();

        $this->bookRepository->add($book, true);

        $this->bookRepository->delete($book->getId());
        $foundBook = $this->bookRepository->find($book->getId());

        $this->assertEmpty($foundBook);
    }

    public function testCreate()
    {

    }

    public function testGetBooksByAuthorId()
    {

    }

    public function testUpdate()
    {

    }

    public function testGetAll()
    {

    }
}
