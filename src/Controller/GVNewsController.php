<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GVNewsController extends AbstractController
{
    #[Route('/news', name: 'news')]
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();

        return $this->render('gv_news/index.html.twig', [
            'controller_name' => 'GVNewsController',
            'articles' => $articles
        ]);
    }

    #[Route('/news/12', name: 'news_show')]
    public function show(){
        return $this->render('gv_news/show.html.twig');
    }
}
