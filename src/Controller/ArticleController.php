<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// /article - все статьи
// /article/название_категории - статьи из конкретной категории
// /article/название_категории/id_статьи - статья по id


class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="all_article")
     */
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/article/{category}", name="article_by_category", methods={"GET"})
     */
    public function byCategory($category){
        dump($category);

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
    // @Route("/article/{category}/{id}", name="article_by_id", defaults={"id"=2})
    // requirements / _format / _locale
    /**
     * @Route("/article/{category}/{id}", name="article_by_id", methods={"GET"})
     */
    public function byId($category, $id=2){

        dump($category);
        dump($id);

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

}
