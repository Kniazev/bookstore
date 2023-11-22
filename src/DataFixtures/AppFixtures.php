<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $book = (new Book())->setTitle('Test book');
        $book1 = (new Book())->setTitle('Test book1');

        $author = (new Author())->setLastName('Test')->setFirstName('Author');
        $author1 = (new Author())->setLastName('Test1')->setFirstName('Author1');
        $manager->persist($book);
        $manager->persist($book1);
        $author->addBook($book);
        $author->addBook($book1);
        $author1->addBook($book1);
        $manager->persist($author);
        $manager->persist($author1);

        $manager->flush();
    }
}
