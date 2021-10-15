<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\News;
use App\Entity\PlayOfTheWeek;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\WorldRecords;
use App\Repository\ArticleRepository;
use App\Repository\PlayOfTheWeekRepository;
use App\Repository\VideoRepository;
use App\Repository\WorldRecordsRepository;
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

    #[Route('/video', name: 'video_index', methods: ['GET'])]
    public function video(VideoRepository $videoRepository): Response
    {
        return $this->render('gv_index/video.html.twig', [
            'videos' => $videoRepository->findBy([],
            ['postedAt' => 'desc'])
        ]);
    }

    #[Route('/video/{id}', name: 'video_show', methods: ['GET'])]
    public function video_show(Video $video): Response
    {
        return $this->render('gv_index/video_show.html.twig', [
            'video' => $video,
        ]);
    }

    #[Route('/article', name: 'article_index', methods: ['GET'])]
    public function article(ArticleRepository $articleRepository): Response
    {
        return $this->render('gv_index/article.html.twig', [
            'articles' => $articleRepository->findBy([],
            ['createdAt' => 'desc']),
        ]);
    }

    #[Route('/article/{id}', name: 'article_show', methods: ['GET'])]
    public function article_show(Article $article): Response
    {
        return $this->render('gv_index/article_show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/news', name: 'news_index', methods: ['GET'])]
    public function news(ArticleRepository $articleRepository): Response
    {
        return $this->render('gv_index/news.html.twig', [
            'articles' => $articleRepository->findBy(
                ['type' => '2'],
                ['createdAt' => 'desc']
            ),
        ]);
    }

    #[Route('/funnystuff', name: 'funnystuff_index', methods: ['GET'])]
    public function funnystuff(VideoRepository $VideoRepository): Response
    {
        return $this->render('gv_index/funnystuff.html.twig', [
            'videos' => $VideoRepository->findBy(
                ['type' => '5'],
                ['postedAt' => 'desc']
            ),
        ]);
    }
}
