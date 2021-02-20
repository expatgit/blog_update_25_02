<?php
namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(Request $request): Response
    {
        // для отладки используется функция dump();
        dump("Отладка");

        // $request->request - $_POST
        // $request->query - $_GET
        // $request->cookies - $_COOKIES
        // $request->files - $_FILES
        // $request->server - $_SERVER
        // $request->headers - заголовки
        // все эти свойства - экземпляры ParameterBag, поэтому обладают
        // одинаковыми методами
        // all() - получить все параметры
        // get('имя_параметра') - получить параметр по имени
        // set('имя_параметра', 'значение') - установить параметр по имени
        // has('имя_параметра') - возвращает true, если параметр существует
        // remove('имя_параметра') - удаляет параметр

        // $_GET ['id' => '1', 'category'=>'wood']
        // $request->query->get('id'); - 1
        // $request->query->get('category'); - wood

        // получение данных
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        dump($articles);

        return $this->render('default/index.html.twig', [
            'articles' => $articles
        ]);
    }
}
