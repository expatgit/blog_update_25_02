<?php
namespace App\Controller;

use App\Entity\Article;
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
    public function byCategory($category){

        dump($category);

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

}
