<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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

    #[Route('/news/create', name: 'news_create')]
    public function create(){

        $article = new Article();

        $form = $this->createFormBuilder($article)
                    ->add('title',TextType::class, [
                        'attr'=>[
                            'placeholder' =>"Titre de l'article"
                        ]
                    ])
                    ->add('content',TextareaType::class, [
                        'attr'=>[
                            'placeholder' =>"Contenu de l'article"
                        ]
                    ])
                    ->add('image',TextType::class,[
                        'attr'=>[
                            'placeholder' =>"Image de l'article"
                        ]
                    ])
                    ->getForm();


        return $this->render('gv_news/create.html.twig', [
            'formArticle' => $form->createView()
        ]);
    }

    #[Route('/news/{id}', name: 'news_show')]
    public function show($id){
        $repo=$this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);
        return $this->render('gv_news/show.html.twig', [
            'article' =>$article
        ]);
    }
}
