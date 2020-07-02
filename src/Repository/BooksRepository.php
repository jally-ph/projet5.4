<?php

namespace App\Repository;

use App\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Books|null find($id, $lockMode = null, $lockVersion = null)
 * @method Books|null findOneBy(array $criteria, array $orderBy = null)
 * @method Books[]    findAll()
 * @method Books[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Books::class);
    }

    public function findByCategory($category)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.books = :cat')
            ->setParameter('cat', $category)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAuthor($author)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.books = :author')
            ->setParameter('author', $author)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByPublic($public)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.books = :public')
            ->setParameter('public', $public)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Books[] Returns an array of Books objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Books
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
