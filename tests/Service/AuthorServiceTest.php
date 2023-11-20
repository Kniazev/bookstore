<?php

namespace Service;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Service\AuthorService;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class AuthorServiceTest extends TestCase
{

    public function testGetBooks()
    {

    }

    public function testDelete()
    {

    }

    public function testGetById()
    {

    }

    public function testGetAll()
    {

    }

    public function testUpdate()
    {

    }

    public function testCreate()
    {
        $author = $this->createMockAuthor();

        $authorRepository = $this->createMock(AuthorRepository::class);
        $authorRepository->expects($this->any())
            ->method('add')
            ->willReturn($author);

        $authorService = new AuthorService($authorRepository);
        $authorService->create($author, true);
    }

    private function createMockAuthor()
    {
        $author = new Author();

        return $author->setFirstName('Name')->setLastName('LastName');
    }
}
