<?php

namespace App\Test\Repository;

use App\Repository\BookRepository;
use App\Tests\AbstractCustomTest;
use App\Tests\MockEntities;
use App\Entity\Book;


class BookRepositoryTest extends AbstractCustomTest
{
    private MockEntities $mockEntities;
    private Object $bookRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockEntities = new MockEntities();
        $this->bookRepository = $this->getRepositoryForEntity(Book::class);
    }

    public function testAdd(): void
    {
        $book = $this->mockEntities->createBook();

        $this->bookRepository->add($book, true);

        $foundBook =  $this->bookRepository->findOneBy(['title'=> self::BOOK_INSERTED_TEST_TITLE]);
        $this->assertNotEmpty($foundBook);
        $this->assertEquals($book->getTitle(), $foundBook->getTitle());
    }

    public function testGetBooksByAuthorId()
    {
        $foundBooks =  $this->bookRepository->getBooksByAuthorId($this->author->getId());

        $this->assertNotEmpty($foundBooks);
    }
}
