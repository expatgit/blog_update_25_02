<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/owner/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('account');
        }

        // получить ошибку входа, если она есть
        $error = $authUtils->getLastAuthenticationError();

        // последнее введенное имя пользователя
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('account/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/account", name="account")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $all_categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        
        return $this->render('account/index.html.twig', [
            'all_categories' => $all_categories,
        ]);
    }
}
