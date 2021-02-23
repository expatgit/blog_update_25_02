<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{

    /**
     * @Route("/article/{id}", name="article_by_id", requirements={"id"="\d+"})
     */
    public function byId($id){

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        return $this->render('article/article.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/article/{category}", name="article_by_category")
     */
    public function byCategory($category){ // url

        $all_categories = $this->getDoctrine() // объект Doctrine
            ->getRepository(Category::class) // объект репозитория
            ->findAll(); // SELECT * FROM CATEGORY;

        $category_by_url = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findByUrl($category);

        return $this->render('article/index.html.twig', [
            'all_categories' => $all_categories,
            'category_by_url' => $category_by_url
        ]);
    }

}

// requirements id - число
// /article/{id} - /article/12

// /article/{category} - /article/yhe6yue64uw64u


