<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search')]
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchBar()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez un mot-clé'
                ]
            ])
            ->add('rechercher', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/handleSearch", name="handleSearch")
     * @param Request $request
     */
    public function handleSearch(Request $request, ArticleRepository $ArticleRepo, VideoRepository $VideoRepo)
    {
        $query = $request->request->get('form')['query'];
        if($query) {
            $articles = $ArticleRepo->findArticlesByName($query);
            $videos = $VideoRepo->findVideosByName($query);
        }
        return $this->render('search/index.html.twig', [
            'articles' => $articles,
            'videos' => $videos,
        ]);
    }



    #[Route('/tags_search', name: 'tags_search')]
    public function searchTagBar()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleTagSearch'))
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez un tag'
                ]
            ])
            ->add('rechercher', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/handleTagSearch", name="handleTagSearch")
     * @param Request $request
     */
    public function handleTagSearch(Request $request, ArticleRepository $ArticleRepo, VideoRepository $VideoRepo)
    {
        $query = $request->request->get('form')['query'];
        if($query) {
            $articles = $ArticleRepo->findArticlesByTag($query);
            $videos = $VideoRepo->findVideosByTag($query);

        }
        return $this->render('search/index.html.twig', [
            'articles' => $articles,
            'videos' => $videos,
        ]);
    }
}
