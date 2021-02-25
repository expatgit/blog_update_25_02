<?php
namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // SELECT * FROM article WHERE id IN (3, 6, 8)
    public function in(array $ids){
        return $this->createQueryBuilder('a') // SELECT * FROM article
            ->andWhere('a.id IN (:ids)')->setParameter('ids', $ids)
            ->getQuery()->getResult();
    }

    // SELECT * FROM article WHERE title LIKE %yetye%
    public function like($title){
        return $this->createQueryBuilder('a')
            ->andWhere('a.title LIKE :title')->setParameter('title', '%'.$title.'%')
            ->getQuery()->getResult();
    }

    public function innerJoin($val, $limit, $offset){
        return $this->createQueryBuilder('a')
            ->innerJoin('a.category', 'c', 'WITH', 'c.url = :val')
            ->setParameter('val', $val)
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function dql($id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a FROM App\Entity\Article a WHERE a.id < :id'
        )->setParameter('id', $id);

        return $query->execute();
    }

//select * from xx where x in (select asd from asd)
// leftJoin

}