<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comments;
use App\Entity\Information;
use App\Entity\News;
use App\Entity\PlayOfTheWeek;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Video;
use App\Entity\WorldRecords;
use App\Form\CommentsType;
use App\Repository\ArticleRepository;
use App\Repository\PlayOfTheWeekRepository;
use App\Repository\VideoRepository;
use App\Repository\WorldRecordRepository;
use App\Repository\WorldRecordsRepository;
use http\Env\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class GVIndexController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(): Response{
        $repositoryArticle = $this->getDoctrine()->getRepository(Article::class);
        $repositoryVideo = $this->getDoctrine()->getRepository(Video::class);
        $repositoryInformation = $this->getDoctrine()->getRepository(Information::class);

        $lastTips = $repositoryArticle->findOneBy(
            ['type' => '7'],
            ['createdAt' => 'desc']
        );

        $lastNews = $repositoryArticle->findOneBy(
            ['type' => '2'],
            ['createdAt' => 'desc']
        );

        $lastPOTW = $repositoryVideo->findOneBy(
            ['type' => '6'],
            ['postedAt' => 'desc']
        );

        $lastFunnyStuff = $repositoryVideo->findOneBy(
            ['type' => '5'],
            ['postedAt' => 'desc']
        );

        $informations = $repositoryInformation->findAll();

        return $this->render('gv_index/index.html.twig', [
            'lastnews' => $lastNews,
            'lasttips' => $lastTips,
            'lastPOTW' => $lastPOTW,
            'lastFunnyStuff' => $lastFunnyStuff,
            'informations' => $informations,
        ]);
    }

    #[Route('/video', name: 'video_index', methods: ['GET'])]
    public function video(VideoRepository $videoRepository,PaginatorInterface $paginator, \Symfony\Component\HttpFoundation\Request $request): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Video::class)->findBy([],
        ['postedAt' => 'desc']);
        $videos = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('gv_index/video.html.twig', [
            'videos' => $videos,
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
    public function article(ArticleRepository $articleRepository, \Symfony\Component\HttpFoundation\Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Article::class)->findBy([],
            ['createdAt' => 'desc']);
        $articles = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('gv_index/article.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{id}', name: 'article_show', methods: ['GET','POST'])]
    public function article_show(Article $article, \Symfony\Component\HttpFoundation\Request $request): Response
    {
        //commentaires
        //on cr??e le commentaire "vierge"
        $comment = new Comments();
        //on g??n??re le formulaire
        $commentForm = $this->createForm(CommentsType::class,$comment);

        $commentForm->handleRequest($request);

        //traitement du formulaire
        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setArticles($article);

            //on r??cup??re le contenu du champ parentid
            $parentid = $commentForm->get("parentid")->getData();

            //on va chercher le commentaire correspondant
            $em = $this->getDoctrine()->getManager();

            if($parentid != null){
                $parent = $em->getRepository(Comments::class)->find($parentid);
            }

            //On d??finit le parent
            $comment->setParent($parent ?? null);

            $em->persist($comment);
            $em->flush();

            $this->addFlash('message','Votre commentaire a bien ??t?? envoy??');
            return $this->redirectToRoute('article_index');
        }


        return $this->render('gv_index/article_show.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm->createView()
        ]);
    }

    #[Route('/news', name: 'news_index', methods: ['GET'])]
    public function news(ArticleRepository $articleRepository, \Symfony\Component\HttpFoundation\Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Article::class)->findBy(
            ['type' => '2'],
            ['createdAt' => 'desc']);
        $articles = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('gv_index/news.html.twig', [
            'articles' => $articles]);
    }

    #[Route('/funnystuff', name: 'funnystuff_index', methods: ['GET'])]
    public function funnystuff(VideoRepository $VideoRepository, \Symfony\Component\HttpFoundation\Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Video::class)->findBy(
            ['type' => 5],
            ['postedAt' => 'desc']
        );

        $videos = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('gv_index/funnystuff.html.twig', [
            'videos' => $videos]);
    }


    #[Route('/tips', name: 'tips_index', methods: ['GET'])]
    public function tips(ArticleRepository $articleRepository, \Symfony\Component\HttpFoundation\Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Article::class)->findBy(
            ['type' => '7'],
            ['createdAt' => 'desc']);
        $articles = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('gv_index/tips.html.twig', [
            'articles' => $articles]);
    }

    #[Route('/playoftheweek', name: 'playoftheweek_index', methods: ['GET'])]
    public function playoftheweek(VideoRepository $VideoRepository, \Symfony\Component\HttpFoundation\Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Video::class)->findBy(
            ['type' => 6],
            ['postedAt' => 'desc']
        );

        $videos = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('gv_index/playoftheweek.html.twig', [
            'videos' => $videos]);
    }

    #[Route('/wr', name: 'world_record_index', methods: ['GET'])]
    public function wr(WorldRecordRepository $worldRecordRepository): Response
    {
        return $this->render('gv_index/wr.html.twig', [
            'world_records' => $worldRecordRepository->findAll(),
        ]);
    }
}
