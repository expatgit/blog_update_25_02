<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index(): Response
    {
        $all_categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        
        return $this->render('account/index.html.twig', [
            'all_categories' => $all_categories,
        ]);
    }
}
