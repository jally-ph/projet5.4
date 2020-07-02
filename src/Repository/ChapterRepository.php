<?php

namespace App\Repository;

use App\Entity\Chapter;
use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chapter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chapter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chapter[]    findAll()
 * @method Chapter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChapterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chapter::class);
    }

    public function findAllByBook($id)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.books = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    // public function findAll($comments)
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.comments = :comments')
    //         ->setParameter('comments', $comments)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    

    // /**
    //  * @return Chapter[] Returns an array of Chapter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Chapter
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
