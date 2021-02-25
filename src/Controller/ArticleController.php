<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Images;
use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="add_article", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function addArticle(ArticleService $service, Request $request){



        $post_data = $request->request->all();

        $article = new Article();
        $article->setTitle($post_data['title']);
        $article->setText($post_data['text']);
        $article->setCreatedOn(new \DateTime('now'));
        $category_by_id = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($post_data['category']);
        $article->setCategory($category_by_id);

        // менеджер сущностей
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($article); // $article перешел под управление менеджера

        // загрузка файлов
        $files = $request->files->get('images');
        foreach ($files as $file){
            // $file->getSize(); // размер файла
            // $file->getClientOriginalName(); // имя файла
            $file_name = 'уникальное_имя.' . $file->guessExtension();
            $file->move(
                $this->getParameter('article_images'),
                $file_name
            );
            $img = new Images();
            $img->setSrc($file_name);
            $img->setAlt($file->getClientOriginalName());
            $img->addArticle($article);
            $entity_manager->persist($img); // $img перешел под управление менеджера
        }

        // добавление данных в таблицы
        $entity_manager->flush();


        // ответ в json формате
        return $this->json([
            'answer' => 'Данные добавлены',
            'id' => $article->getId()
        ]);
    }

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

    /**
     * @Route("/article/delete/{category}/{id}", name="article_delete")
     */
    public function deleteById($category, $id){

        $entityManager = $this->getDoctrine()->getManager();

        $article =  $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        $entityManager->remove($article);
        $entityManager->flush();

        // перенаправления:
        // return $this->redirectToRoute('homepage');
        // return $this->redirectToRoute('homepage', [], 301);
        // return $this->redirectToRoute('app_lucky_number', ['max' => 10]);
        // return $this->redirectToRoute('blog_show', $request->query->all());

        return $this->redirectToRoute('article_by_category', ['category' => $category]);
    }
}
