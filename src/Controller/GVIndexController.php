<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class GVIndexController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(): Response{

        return $this->render('gv_index/index.html.twig');
    }

    #[Route('/home', name: 'home')]
    public function home(): Response{

        return $this->render('gv_index/home.html.twig',[
            'controller_name' => "GVHomeController"
        ]);
    }

    #[Route('/news', name: 'news')]
    public function news(): Response{
        $repo = $this->getDoctrine()->getRepository(News::class);
        $news = $repo->findAll();

        return $this->render('gv_index/news.html.twig',[
            'controller_name' => "News",
            'new' => $news
        ]);
    }

    #[Route('/news/{id}', name: 'news_show', methods: ['GET'])]
    public function show(News $news): Response
    {
        return $this->render('gv_index/news_show.html.twig', [
            'news' => $news,
        ]);
    }

}
