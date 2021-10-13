<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\PlayOfTheWeek;
use App\Entity\User;
use App\Entity\WorldRecords;
use App\Repository\PlayOfTheWeekRepository;
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
    public function news_show(News $news): Response
    {
        return $this->render('gv_index/news_show.html.twig', [
            'news' => $news,
        ]);
    }

    #[Route('/potw', name: 'potw_index', methods: ['GET'])]
    public function potw(PlayOfTheWeekRepository $playOfTheWeekRepository): Response
    {
        return $this->render('gv_index/potw.html.twig', [
            'play_of_the_weeks' => $playOfTheWeekRepository->findAll(),
        ]);
    }
    #[Route('/potw/{id}', name: 'potw_show', methods: ['GET'])]
    public function potw_show(PlayOfTheWeek $playOfTheWeek): Response
    {
        return $this->render('gv_index/potw_show.html.twig', [
            'play_of_the_week' => $playOfTheWeek,
        ]);
    }

    #[Route('/wr', name: 'wr_index', methods: ['GET'])]
    public function wr(WorldRecordsRepository $worldRecordsRepository): Response
    {
        return $this->render('gv_index/wr.html.twig', [
            'world_records' => $worldRecordsRepository->findAll(),
        ]);
    }

    #[Route('/wr/{id}', name: 'wr_show', methods: ['GET'])]
    public function wr_show(WorldRecords $worldRecord): Response
    {
        return $this->render('gv_index/wr_show.html.twig', [
            'world_record' => $worldRecord,
        ]);
    }





}
