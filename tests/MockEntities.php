<?php

namespace App\Tests;

use App\Entity\Book;

class MockEntities
{
    public function createBook(): Book
    {
        $book = new Book();

        return $book->setTitle('Test inserted book');
    }
}
