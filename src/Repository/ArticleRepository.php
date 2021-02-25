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

    public function in(array $ids){
        return $this->createQueryBuilder('a')
            ->andWhere('a.id IN (:ids)')->setParameter('ids', $ids)
            ->getQuery()->getResult();
    }

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

}