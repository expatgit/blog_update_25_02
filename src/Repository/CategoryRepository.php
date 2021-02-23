<?php


namespace App\Repository;


use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findByUrl($url){
        // SELECT * FROM category WHERE url = $url;
        // $this->createQueryBuilder('c.name') // SELECT name FROM category
        return $this->createQueryBuilder('c') // SELECT * FROM category
            ->andWhere('c.url = :url_val') // WHERE url = :url_val
            ->setParameter('url_val', $url) // ['url_val' => $url]
            ->getQuery()
            ->getSingleResult();
    }
}