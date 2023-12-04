<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    use RepositoryModifyTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function add(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param int $authorId
     * @return Query
     */
    public function getBooksByAuthorId(int $authorId): Query
    {
        return $this->createQueryBuilder('book')
            ->select('book')
            ->leftJoin('book.authors', 'authors')
            ->where('authors.id = :id')
            ->setParameter('id', $authorId)
            ->getQuery();
    }

    /**
     * @param string $name
     * @return Query
     */
    public function getBooksByAuthorName(string $name): Query
    {
        return $this->createQueryBuilder('book')
            ->select('book')
            ->leftJoin('book.authors', 'authors')
            ->where('authors.firstName = :name')
            ->orWhere('authors.lastName = :name')
            ->setParameter('name', $name)
            ->getQuery();
    }

    public function remove(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
